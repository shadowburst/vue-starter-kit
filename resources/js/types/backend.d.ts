export type BannerAdminFormProps = {
    banner?: BannerResource;
};
export type BannerAdminFormRequest = {
    name: string;
    message: string;
    action?: string;
    is_enabled: boolean;
};
export type BannerAdminIndexProps = {
    banners?: {
        data: Array<BannerResource>;
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
};
export type BannerOneOrManyRequest = {
    banner?: number;
    ids?: Array<number>;
};
export type BannerResource = {
    id: number;
    name: string;
    message: string;
    action?: string;
    is_enabled: boolean;
};
export type ConfirmPasswordProps = {};
export type ConfirmPasswordRequest = {
    password: string;
};
export type DashboardAdminIndexProps = {};
export type DashboardIndexProps = {};
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
export type MediaFormRequest = {
    model_type: string;
    model_id: number;
    collection: string;
    file: File;
};
export type MediaResource = {
    id: number;
    uuid: string;
    url: string;
    custom_properties?: Record<string, any>;
};
export type PermissionName = 'users';
export type PermissionResource = {
    id: number;
    name: string;
    display_name: string;
};
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
export type RoleName = 'tester' | 'owner' | 'member' | 'editor';
export type RoleResource = {
    id: number;
    name: string;
    display_name: string;
};
export type TeamFormProps = {
    team?: TeamResource;
};
export type TeamFormRequest = {
    name: string;
    logo?: string;
    settings?: TeamSettingsData;
};
export type TeamIndexProps = {
    request: TeamIndexRequest;
    teams?: {
        data: Array<TeamResource>;
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
    trashedFilters?: Array<{ value: TrashedFilter; label: string }>;
};
export type TeamIndexRequest = {
    q?: string;
    page?: number;
    per_page?: number;
    sort_by: string;
    sort_direction: string;
    trashed?: TrashedFilter;
};
export type TeamOneOrManyRequest = {
    team?: number;
    ids?: Array<number>;
};
export type TeamResource = {
    id: number;
    name: string;
    settings?: TeamSettingsData;
    deleted_at?: string;
    can_view?: boolean;
    can_update?: boolean;
    can_trash?: boolean;
    can_restore?: boolean;
    can_delete?: boolean;
    creator?: UserResource;
    logo?: MediaResource;
};
export type TeamSettingsData = {};
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
    phone?: string;
    email: string;
    avatar?: string;
};
export type UserAbilitiesResource = {
    teams: { view_any: boolean; create: boolean };
    users: { view_any: boolean; create: boolean };
};
export type UserMemberFormProps = {
    user?: UserResource;
    teams?: Array<TeamResource>;
    permissions?: Array<{ value: PermissionName; label: string }>;
};
export type UserMemberFormRequest = {
    first_name: string;
    last_name: string;
    email: string;
    phone?: string;
    password?: string;
    password_confirmation?: string;
    avatar?: string;
    team_roles: Array<UserTeamRoleData>;
    team_permissions: Array<UserTeamPermissionData>;
};
export type UserMemberIndexProps = {
    request: UserMemberIndexRequest;
    users?: {
        data: Array<UserResource>;
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
    trashedFilters?: Array<{ value: TrashedFilter; label: string }>;
};
export type UserMemberIndexRequest = {
    q?: string;
    page?: number;
    per_page?: number;
    sort_by: string;
    sort_direction: string;
    trashed?: TrashedFilter;
};
export type UserMemberOneOrManyRequest = {
    user?: number;
    ids?: Array<number>;
};
export type UserResource = {
    id: number;
    is_admin: boolean;
    owner_id: number;
    team_id?: number;
    first_name: string;
    last_name: string;
    full_name: string;
    email: string;
    phone?: string;
    creator_id?: number;
    deleted_at?: string;
    is_owner?: boolean;
    is_member?: boolean;
    is_editor?: boolean;
    is_trashed?: boolean;
    can_view?: boolean;
    can_update?: boolean;
    can_trash?: boolean;
    can_restore?: boolean;
    can_delete?: boolean;
    permissions?: Array<PermissionName>;
    avatar?: MediaResource;
    owner?: UserResource;
    team?: TeamResource;
    active_members?: Array<UserResource>;
    members?: Array<UserResource>;
    teams?: Array<TeamResource>;
    team_roles?: Array<UserTeamRoleData>;
    team_permissions?: Array<UserTeamPermissionData>;
};
export type UserTeamPermissionData = {
    team_id: number;
    permission: PermissionName;
};
export type UserTeamRoleData = {
    team_id: number;
    role: RoleName;
};
export type VerifyEmailProps = {};
export type VerifyEmailRequest = {
    code: string;
};
