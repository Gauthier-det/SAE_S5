import React, { createContext, useContext, useState, useCallback } from 'react';
import type { ReactNode } from 'react';
import {
    Snackbar,
    Alert,
    AlertTitle,
    IconButton,
    Stack,
    Slide
} from '@mui/material';
import type { AlertColor } from '@mui/material';
import CheckIcon from '@mui/icons-material/Check';
import CloseIcon from '@mui/icons-material/Close';

interface AlertOptions {
    severity?: AlertColor;
    duration?: number;
    title?: string;
}

interface ConfirmOptions {
    title?: string;
    message: string;
    severity?: AlertColor;
    onAccept: () => void;
    onDeny?: () => void;
}

interface AlertContextType {
    showAlert: (message: string, options?: AlertColor | AlertOptions) => void;
    showConfirm: (options: ConfirmOptions) => void;
}

const AlertContext = createContext<AlertContextType | undefined>(undefined);

export const useAlert = () => {
    const context = useContext(AlertContext);
    if (!context) {
        throw new Error('useAlert must be used within an AlertProvider');
    }
    return context;
};

interface AlertProviderProps {
    children: ReactNode;
}

interface SnackbarConfig {
    open: boolean;
    message: string;
    severity: AlertColor;
    duration: number | null;
    isConfirmation: boolean;
    onAccept?: () => void;
    onDeny?: () => void;
}

export const AlertProvider: React.FC<AlertProviderProps> = ({ children }) => {
    const [config, setConfig] = useState<SnackbarConfig>({
        open: false,
        message: '',
        severity: 'info',
        duration: 5000,
        isConfirmation: false
    });

    const showAlert = useCallback((message: string, options?: AlertColor | AlertOptions) => {
        let severity: AlertColor = 'info';
        let duration = 6000;

        if (typeof options === 'string') {
            severity = options;
        } else if (options) {
            severity = options.severity || 'info';
            duration = options.duration !== undefined ? options.duration : 6000;
        }

        setConfig({
            open: true,
            message,
            severity,
            duration,
            isConfirmation: false
        });
    }, []);

    const showConfirm = useCallback((options: ConfirmOptions) => {
        setConfig({
            open: true,
            message: options.message,
            severity: options.severity || 'warning',
            duration: null,
            isConfirmation: true,
            onAccept: options.onAccept,
            onDeny: options.onDeny
        });
    }, []);

    const handleAccept = () => {
        if (config.onAccept) config.onAccept();
        setConfig(prev => ({ ...prev, open: false }));
    };

    const handleDeny = () => {
        if (config.onDeny) config.onDeny();
        setConfig(prev => ({ ...prev, open: false }));
    };

    const handleClose = (event?: React.SyntheticEvent | Event, reason?: string) => {
        if (config.isConfirmation) {
            handleDeny();
            return;
        }
        setConfig(prev => ({ ...prev, open: false }));
    };

    return (
        <AlertContext.Provider value={{ showAlert, showConfirm }}>
            {children}
            <Slide direction="up" in={config.open} mountOnEnter unmountOnExit>
                <Snackbar
                    open={config.open}
                    autoHideDuration={config.duration}
                    onClose={handleClose}
                >
                    <Alert
                        severity={config.severity}
                        action={config.isConfirmation && (
                            <Stack direction="row" spacing={1}>
                                <IconButton
                                    size="small"
                                    aria-label="accept"
                                    color="success"
                                    onClick={handleAccept}
                                >
                                    <CheckIcon fontSize="small" />
                                </IconButton>
                                <IconButton
                                    size="small"
                                    aria-label="deny"
                                    color="error"
                                    onClick={handleDeny}
                                >
                                    <CloseIcon fontSize="small" />
                                </IconButton>
                            </Stack>
                        )}
                    >
                        {config.message}
                    </Alert>
                </Snackbar>
            </Slide>
        </AlertContext.Provider>
    );
};
