import React, { createContext, useContext, useState, useEffect, type ReactNode } from 'react';
import type { User } from '../models/user.model';
import type { Login, Register } from '../models/auth.model';
import { getUser, isClubManager, isRaidManager } from '../api/user';
import { apiLogin, apiLogout, apiRegister } from '../api/auth';

interface UserContextType {
    user: User | null;
    login: (creds: Login) => Promise<void>;
    register: (creds: Register) => Promise<void>;
    logout: () => void;
    isAuthenticated: boolean;
    loading: boolean;
    isClubManager: boolean;
    isRaidManager: boolean;
}

const UserContext = createContext<UserContextType | undefined>(undefined);

export const UserProvider: React.FC<{ children: ReactNode }> = ({ children }) => {
    const [user, setUser] = useState<User | null>(null);
    const [isAuthenticated, setIsAuthenticated] = useState<boolean>(false);
    const [loading, setLoading] = useState<boolean>(true);
    const [isClubManagerUser, setIsClubManagerUser] = useState<boolean>(false);
    const [isRaidManagerUser, setIsRaidManagerUser] = useState<boolean>(false);

    const updateRoles = async (userData: User) => {
        try {
            const clubMgr = await isClubManager(userData.USE_ID);
            const raidMgr = await isRaidManager(userData.USE_ID);
            setIsClubManagerUser(clubMgr);
            setIsRaidManagerUser(raidMgr);
        } catch (e) {
            console.error("Failed to fetch roles", e);
            setIsClubManagerUser(false);
            setIsRaidManagerUser(false);
        }
    }

    useEffect(() => {
        const initSession = async () => {
            const token = localStorage.getItem('token');
            if (token) {
                try {
                    const userData = await getUser();
                    setUser(userData);
                    setIsAuthenticated(true);
                    await updateRoles(userData);
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
        setUser(null);
        setIsAuthenticated(false);
        setIsClubManagerUser(false);
        setIsRaidManagerUser(false);
    };

    return (
        <UserContext.Provider value={{
            user,
            login,
            register,
            logout,
            isAuthenticated,
            loading,
            isClubManager: isClubManagerUser,
            isRaidManager: isRaidManagerUser
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
