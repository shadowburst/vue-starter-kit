export type AuthUserResource = {
    id: number;
    first_name: string;
    last_name: string;
    full_name: string;
    initials: string;
    email: string;
    avatar?: MediaResource;
};
export type BannerAdminCreateProps = {};
export type BannerAdminDeleteRequest = {
    banners: { [key: number]: any };
    banner?: number;
    ids?: Array<any>;
};
export type BannerAdminEditProps = {
    banner: BannerAdminFormResource;
};
export type BannerAdminFormRequest = {
    name: string;
    message: string;
    action?: string;
    start_date: string;
    end_date: string;
};
export type BannerAdminFormResource = {
    id: number;
    name: string;
    message: string;
    action: string;
    start_date: string;
    end_date: string;
};
export type BannerAdminIndexProps = {
    banners: {
        data: Array<BannerAdminIndexResource>;
        links: Array<{ url: string; label: string; active: boolean }>;
        meta: {
            current_page: number;
            first_page_url: string;
            from: number;
            last_page: number;
            last_page_url: string;
            next_page_url: string;
            path: string;
            per_page: number;
            prev_page_url: string;
            to: number;
            total: number;
        };
    };
};
export type BannerAdminIndexRequest = {
    q?: string;
    page?: number;
    per_page?: number;
};
export type BannerAdminIndexResource = {
    id: number;
    name: string;
    start_date: string;
    end_date: string;
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
export type MediaResource = {
    id: number;
    uuid: string;
    url: string;
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
export type StoreMediaRequest = {
    model_type: string;
    model_id: number;
    collection: string;
    file: any;
};
export type ToastMessagesData = {
    info?: string;
    success?: string;
    warning?: string;
    error?: string;
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
    avatar?: string;
};
export type VerifyEmailProps = {};
export type VerifyEmailRequest = {
    code: string;
};
