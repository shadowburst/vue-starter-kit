export type AuthUserResource = {
    id: number;
    first_name: string;
    last_name: string;
    full_name: string;
    email: string;
};
export type ConfirmPasswordRequest = {
    password: string;
};
export type ForgotPasswordProps = {
    status?: string;
};
export type ForgotPasswordRequest = {
    email: string;
};
export type LoginProps = {
    canResetPassword: boolean;
    status?: string;
};
export type LoginRequest = {
    email: string;
    password: string;
    remember?: boolean;
};
export type RegisterProps = {
    status?: string;
};
export type RegisterRequest = {
    first_name: string;
    last_name: string;
    email: string;
    password: string;
    password_confirmation: string;
};
export type ResetPasswordProps = {
    token: string;
    email: string;
    status?: string;
};
export type ResetPasswordRequest = {
    token: string;
    email: string;
    password: string;
    password_confirmation: string;
};
export type VerifyEmailProps = {
    status?: string;
};
export type VerifyEmailRequest = {
    code: string;
};
