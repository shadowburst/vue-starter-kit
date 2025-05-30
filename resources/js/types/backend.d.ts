export type AddressData = {
    full: string;
    line_1: string;
    line_2?: string;
    postal_code: string;
    city: string;
    country: string;
    lat?: string;
    lng?: string;
};
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
export type BannerAdminEditProps = {
    banner: BannerAdminFormResource;
};
export type BannerAdminFormRequest = {
    name: string;
    message: string;
    action?: string;
    start_date: string;
    end_date: string;
    is_enabled: boolean;
};
export type BannerAdminFormResource = {
    id: number;
    name: string;
    message: string;
    action?: string;
    start_date: string;
    end_date: string;
    is_enabled: boolean;
};
export type BannerAdminIndexProps = {
    banners?: {
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
    sort_by: string;
    sort_direction: string;
    is_enabled?: boolean;
    start_date?: string;
    end_date?: string;
};
export type BannerAdminIndexResource = {
    id: number;
    name: string;
    start_date: string;
    end_date: string;
    is_enabled: boolean;
};
export type BannerAppResource = {
    id: number;
    name: string;
    message: string;
    action?: string;
};
export type BannerOneOrManyRequest = {
    banner?: number;
    ids?: Array<number>;
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
export type UserAdminCreateProps = {};
export type UserAdminEditProps = {
    user: UserAdminFormResource;
};
export type UserAdminFormRequest = {
    first_name: string;
    last_name: string;
    email: string;
    phone: string;
};
export type UserAdminFormResource = {
    id: number;
    first_name: string;
    last_name: string;
    email: string;
    is_trashed: boolean;
};
export type UserAdminIndexProps = {
    users?: {
        data: Array<UserAdminIndexResource>;
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
export type UserAdminIndexRequest = {
    q?: string;
    page?: number;
    per_page?: number;
    sort_by: string;
    sort_direction: string;
    with_trashed?: boolean;
};
export type UserAdminIndexResource = {
    id: number;
    full_name: string;
    initials: string;
    email: string;
    avatar?: MediaResource;
    is_trashed: boolean;
};
export type UserOneOrManyRequest = {
    user?: number;
    ids?: Array<number>;
};
export type VerifyEmailProps = {};
export type VerifyEmailRequest = {
    code: string;
};
