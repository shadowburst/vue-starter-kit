export type AuthUserResource = {
    id: number;
    first_name: string;
    last_name: string;
    full_name: string;
    email: string;
};
export type ConfirmPasswordProps = {};
export type ConfirmPasswordRequest = {
    password: string;
};
export type EditAppearanceSettingsProps = {};
export type EditProfileSettingsProps = {
    mustVerifyEmail: boolean;
};
export type EditSecuritySettingsProps = {};
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
export type RegisterProps = {};
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
};
export type ResetPasswordRequest = {
    token: string;
    email: string;
    password: string;
    password_confirmation: string;
};
export type UpdatePasswordSettingsRequest = {
    current_password: string;
    password: string;
    password_confirmation: string;
};
export type UpdateProfileSettingsRequest = {
    first_name: string;
    last_name: string;
    email: string;
};
export type VerifyEmailProps = {};
export type VerifyEmailRequest = {
    code: string;
};
