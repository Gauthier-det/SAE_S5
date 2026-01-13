import React, { createContext, useContext, useState, useEffect, type ReactNode } from 'react';
import type { User } from '../model/db/userDbModel';
import type { Login, Register } from '../model/domain/authModel';
import { getUser } from '../api/user';
import { apiLogin, apiLogout, apiRegister } from '../api/auth';

interface UserContextType {
    user: User | null;
    login: (creds: Login) => Promise<void>;
    register: (creds: Register) => Promise<void>;
    logout: () => void;
    isAuthenticated: boolean;
    loading: boolean;
}

const UserContext = createContext<UserContextType | undefined>(undefined);

export const UserProvider: React.FC<{ children: ReactNode }> = ({ children }) => {
    const [user, setUser] = useState<User | null>(null);
    const [isAuthenticated, setIsAuthenticated] = useState<boolean>(false);
    const [loading, setLoading] = useState<boolean>(true);

    useEffect(() => {
        const initSession = async () => {
            const token = localStorage.getItem('token');
            if (token) {
                try {
                    const userData = await getUser();
                    setUser(userData);
                    setIsAuthenticated(true);
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
    };

    return (
        <UserContext.Provider value={{ user, login, register, logout, isAuthenticated, loading }}>
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
