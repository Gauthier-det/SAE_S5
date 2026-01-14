import React from 'react';
import { Navigate, Outlet, useLocation } from 'react-router-dom';
import { useUser } from '../../contexts/userContext';

interface ProtectedRouteProps {
    condition?: boolean;
}

const ProtectedRoute: React.FC<ProtectedRouteProps> = ({ condition }) => {
    const { user, isAuthenticated } = useUser();
    const location = useLocation();

    if (!user || !isAuthenticated) {
        return <Navigate to="/login" state={{ from: location }} replace />;
    }

    if (condition) {
        return <Navigate to="/" replace />;
    }

    return <Outlet />;
};

export default ProtectedRoute;
