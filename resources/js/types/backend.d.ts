export type ConfirmPasswordRequest = {
    password: string;
};
export type LoginRequest = {
    email: string;
    password: string;
    remember?: boolean;
};
export type NewPasswordRequest = {
    token: string;
    email: string;
    password: string;
    password_confirmation: string;
};
export type PasswordResetRequest = {
    email: string;
};
export type RegisterRequest = {
    first_name: string;
    last_name: string;
    email: string;
    password: string;
    password_confirmation: string;
};
export type VerifyCodeRequest = {
    code: string;
};
