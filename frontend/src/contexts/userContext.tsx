import React, { createContext, useContext, useState, useEffect, type ReactNode } from 'react';
import type { User } from '../model/db/userDbModel';
import type { Login } from '../model/domain/loginModel';
import { getUserWithToken } from '../api/user';
import { apiLogin } from '../api/auth';

interface UserContextType {
    user: User | null;
    login: (creds: Login) => Promise<void>;
    logout: () => void;
    isAuthenticated: boolean;
}

const UserContext = createContext<UserContextType | undefined>(undefined);

export const UserProvider: React.FC<{ children: ReactNode }> = ({ children }) => {
    const [user, setUser] = useState<User | null>(null);
    const [isAuthenticated, setIsAuthenticated] = useState<boolean>(false);

    useEffect(() => {
        const token = localStorage.getItem('token');
        if (token) {
            try {
                const userData = getUserWithToken();
                setUser(userData);
                setIsAuthenticated(true);
            } catch (error) {
                console.error("Failed to restore session", error);
                logout();
            }
        }
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

    const logout = () => {
        localStorage.removeItem('token');
        setUser(null);
        setIsAuthenticated(false);
    };

    return (
        <UserContext.Provider value={{ user, login, logout, isAuthenticated }}>
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
