import React, { createContext, useContext, useState, useEffect, type ReactNode } from 'react';
import type { User } from '../models/user.model';
import type { Login, Register } from '../models/auth.model';
import { getUser, isAdmin, isClubManager, isRaceManager, isRaidManager } from '../api/user';
import { apiLogin, apiLogout, apiRegister } from '../api/auth';

interface UserContextType {
    user: User | null;
    login: (creds: Login) => Promise<void>;
    register: (creds: Register) => Promise<void>;
    logout: () => void;
    refreshUser: () => Promise<void>;
    isAuthenticated: boolean;
    loading: boolean;
    isClubManager: boolean;
    isRaidManager: boolean;
    isRaceManager: boolean;
    isAdmin: boolean;
}

const UserContext = createContext<UserContextType | undefined>(undefined);

export const UserProvider: React.FC<{ children: ReactNode }> = ({ children }) => {
    const [user, setUser] = useState<User | null>(null);
    const [isAuthenticated, setIsAuthenticated] = useState<boolean>(false);
    const [loading, setLoading] = useState<boolean>(true);
    const [isClubManagerUser, setIsClubManagerUser] = useState<boolean>(false);
    const [isRaidManagerUser, setIsRaidManagerUser] = useState<boolean>(false);
    const [isRaceManagerUser, setIsRaceManagerUser] = useState<boolean>(false);
    const [isAdminUser, setIsAdminUser] = useState<boolean>(false);


    const updateRoles = async (userData: User) => {
        try {
            const clubMgr = await isClubManager(userData.USE_ID);
            const raidMgr = await isRaidManager(userData.USE_ID);
            const raceMgr = await isRaceManager(userData.USE_ID);
            const admin = await isAdmin();
            setIsClubManagerUser(clubMgr);
            setIsRaidManagerUser(raidMgr);
            setIsRaceManagerUser(raceMgr);
            setIsAdminUser(admin);
        } catch (e) {
            console.error("Failed to fetch roles", e);
            setIsClubManagerUser(false);
            setIsRaidManagerUser(false);
            setIsRaceManagerUser(false);
            setIsAdminUser(false);

        }
    }

    const refreshUser = async () => {
        try {
            const userData = await getUser();
            setUser(userData);
            setIsAuthenticated(true);
            await updateRoles(userData);
        } catch (error) {
            console.error("Failed to refresh user", error);
            // Don't logout on simple refresh fail to avoid UX jumping, 
            // but if init fails it might be token issue.
        }
    };

    useEffect(() => {
        const initSession = async () => {
            const token = localStorage.getItem('token');
            const storedUser = sessionStorage.getItem('user');

            if (token) {
                if (storedUser) {
                    try {
                        const parsedUser = JSON.parse(storedUser);
                        setUser(parsedUser);
                        setIsAuthenticated(true);
                        // Optimistically set roles based on stored data if possible? 
                        // Actually, better to wait for specific check, OR assume false until refreshUser runs.
                        // But wait, refreshUser calls updateRoles.
                    } catch (e) {
                        console.error("Failed to parse stored user", e);
                        sessionStorage.removeItem('user');
                    }
                }

                try {
                    await refreshUser();
                } catch (error) {
                    console.error("Failed to restore session", error);
                    logout();
                }
            }
            setLoading(false);
        };

        initSession();
    }, []);

    const login = async (creds: Login) => {
        try {
            const { token, user } = await apiLogin(creds);
            localStorage.setItem('token', token);
            sessionStorage.setItem('user', JSON.stringify(user));
            setUser(user);
            setIsAuthenticated(true);
            await updateRoles(user);
        } catch (error) {
            console.error("Login failed", error);
            throw error;
        }
    };

    const register = async (creds: Register) => {
        try {
            const { token, user } = await apiRegister(creds);
            localStorage.setItem('token', token);
            sessionStorage.setItem('user', JSON.stringify(user));
            setUser(user);
            setIsAuthenticated(true);
            await updateRoles(user);
        } catch (error) {
            console.error("Register failed", error);
            throw error;
        }
    };

    const logout = () => {
        apiLogout().catch(() => { });
        localStorage.removeItem('token');
        sessionStorage.removeItem('user');
        setUser(null);
        setIsAuthenticated(false);
        setIsClubManagerUser(false);
        setIsRaidManagerUser(false);
        setIsAdminUser(false);
    };

    return (
        <UserContext.Provider value={{
            user,
            login,
            register,
            logout,
            refreshUser,
            isAuthenticated,
            loading,
            isClubManager: isClubManagerUser,
            isRaidManager: isRaidManagerUser,
            isRaceManager: isRaceManagerUser,
            isAdmin: isAdminUser
        }}>
            {children}
        </UserContext.Provider>
    );
};

export const useUser = (): UserContextType => {
    const context = useContext(UserContext);
    if (!context) {
        throw new Error('useUser must be used within a UserProvider');
    }
    return context;
};
