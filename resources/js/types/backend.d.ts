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
export type PermissionName = '*' | 'teams' | 'users';
export type RegisterProps = {};
export type RegisterRequest = {
    first_name: string;
    last_name: string;
    phone: string;
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
export type RoleListResource = {
    id: number;
    name: string;
};
export type RoleName = 'tester' | 'owner' | 'member' | 'viewer' | 'editor';
export type StoreMediaRequest = {
    model_type: string;
    model_id: number;
    collection: string;
    file: any;
};
export type TeamAppResource = {
    id: number;
    name: string;
};
export type TeamCreateProps = {};
export type TeamEditProps = {
    team: TeamFormResource;
};
export type TeamFirstCreateProps = {};
export type TeamFirstRequiredProps = {};
export type TeamFormRequest = {
    name: string;
};
export type TeamFormResource = {
    id: number;
    name: string;
};
export type TeamIndexProps = {
    request: TeamIndexRequest;
    teams?: {
        data: Array<TeamIndexResource>;
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
export type TeamIndexRequest = {
    q?: string;
    page?: number;
    per_page?: number;
    sort_by: string;
    sort_direction: string;
    trashed?: TrashedFilter;
};
export type TeamIndexResource = {
    id: number;
    name: string;
    deleted_at?: string;
    can_trash: boolean;
    can_restore: boolean;
    can_delete: boolean;
};
export type TeamListResource = {
    id: number;
    name: string;
};
export type TeamOneOrManyOnlyTrashedRequest = {
    team?: number;
    ids?: Array<number>;
};
export type TeamOneOrManyRequest = {
    team?: number;
    ids?: Array<number>;
};
export type TeamOneOrManyWithTrashedRequest = {
    team?: number;
    ids?: Array<number>;
};
export type ToastMessagesData = {
    info?: string;
    success?: string;
    warning?: string;
    error?: string;
};
export type TrashedFilter = 'only' | 'with';
export type UpdatePasswordSettingsRequest = {
    current_password: string;
    password: string;
    password_confirmation: string;
};
export type UpdateProfileSettingsRequest = {
    first_name: string;
    last_name: string;
    phone: string;
    email: string;
    avatar?: string;
};
export type UserAbilitiesResource = {
    view_any_teams: boolean;
    create_teams: boolean;
    view_any_users: boolean;
    create_users: boolean;
};
export type UserAuthResource = {
    id: number;
    team_id?: number;
    first_name: string;
    last_name: string;
    full_name: string;
    phone?: string;
    email: string;
    avatar?: MediaResource;
    is_admin: boolean;
    is_owner: boolean;
    is_member: boolean;
    teams: Array<TeamListResource>;
};
export type UserCreateProps = {};
export type UserEditProps = {
    user: UserFormResource;
};
export type UserFormRequest = {
    first_name: string;
    last_name: string;
    email: string;
    phone?: string;
    password?: string;
    password_confirmation?: string;
};
export type UserFormResource = {
    id: number;
    first_name: string;
    last_name: string;
    email: string;
    phone?: string;
};
export type UserIndexProps = {
    request: UserIndexRequest;
    users?: {
        data: Array<UserIndexResource>;
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
export type UserIndexRequest = {
    q?: string;
    page?: number;
    per_page?: number;
    sort_by: string;
    sort_direction: string;
    trashed?: TrashedFilter;
};
export type UserIndexResource = {
    id: number;
    first_name: string;
    last_name: string;
    full_name: string;
    email: string;
    phone?: string;
    avatar?: MediaResource;
    deleted_at?: string;
    can_view: boolean;
    can_update: boolean;
    can_trash: boolean;
    can_restore: boolean;
    can_delete: boolean;
};
export type UserListResource = {
    id: number;
    full_name: string;
};
export type UserOneOrManyOnlyTrashedRequest = {
    user?: number;
    ids?: Array<number>;
};
export type UserOneOrManyRequest = {
    user?: number;
    ids?: Array<number>;
};
export type UserOneOrManyWithTrashedRequest = {
    user?: number;
    ids?: Array<number>;
};
export type VerifyEmailProps = {};
export type VerifyEmailRequest = {
    code: string;
};
