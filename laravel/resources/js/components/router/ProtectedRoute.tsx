import React from 'react';
import { Navigate, Outlet, useLocation } from 'react-router-dom';
import { useUser } from '../../contexts/userContext';
import type { User } from '../../model/db/userDbModel';

interface ProtectedRouteProps {
    condition?: (user: User) => boolean;
}

const ProtectedRoute: React.FC<ProtectedRouteProps> = ({ condition }) => {
    const { user, isAuthenticated } = useUser();
    const location = useLocation();

    if (!isAuthenticated || !user) {
        return <Navigate to="/login" state={{ from: location }} replace />;
    }

    if (condition && !condition(user)) {
        return <Navigate to="/" replace />;
    }

    return <Outlet />;
};

export default ProtectedRoute;
