export type BannerAdminFormProps = {
    banner?: BannerAdminFormResource;
};
export type BannerAdminFormRequest = {
    name: string;
    message: string;
    action?: string;
    is_enabled: boolean;
};
export type BannerAdminFormResource = {
    id: number;
    name: string;
    message: string;
    action?: string;
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
};
export type BannerAdminIndexResource = {
    id: number;
    name: string;
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
export type PermissionListResource = {
    id: number;
    name: string;
    display_name: string;
};
export type PermissionName = {
    name: string;
    value: string;
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
export type RoleListResource = {
    id: number;
    name: string;
    display_name: string;
};
export type RoleName = 'tester' | 'owner' | 'member' | 'editor';
export type TeamFormProps = {
    team?: TeamFormResource;
};
export type TeamFormRequest = {
    name: string;
};
export type TeamFormResource = {
    id: number;
    creator_id: number;
    name: string;
    can_view: boolean;
    can_update: boolean;
    can_trash: boolean;
    can_restore: boolean;
    can_delete: boolean;
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
export type TeamIndexResource = {
    id: number;
    creator_id: number;
    name: string;
    can_view: boolean;
    can_update: boolean;
    can_trash: boolean;
    can_restore: boolean;
    can_delete: boolean;
    deleted_at?: string;
};
export type TeamListResource = {
    id: number;
    name: string;
};
export type TeamOneOrManyRequest = {
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
    phone?: string;
    email: string;
    avatar?: string;
};
export type UserAbilitiesResource = {
    teams: { view_any: boolean; create: boolean };
    users: { view_any: boolean; create: boolean };
};
export type UserListResource = {
    id: number;
    full_name: string;
};
export type UserMemberFormProps = {
    user?: UserMemberFormResource;
    teams?: Array<TeamListResource>;
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
    team_roles: Array<UserMemberFormTeamRoleData>;
    team_permissions: Array<UserMemberFormTeamPermissionData>;
};
export type UserMemberFormResource = {
    id: number;
    first_name: string;
    last_name: string;
    email: string;
    phone?: string;
    can_view: boolean;
    can_update: boolean;
    can_trash: boolean;
    can_restore: boolean;
    can_delete: boolean;
    avatar?: MediaResource;
    team_roles: Array<UserMemberFormTeamRoleData>;
    team_permissions: Array<UserMemberFormTeamPermissionData>;
};
export type UserMemberFormTeamPermissionData = {
    team_id: number;
    permission: PermissionName;
    can_update?: boolean;
};
export type UserMemberFormTeamRoleData = {
    team_id: number;
    role: RoleName;
    can_update?: boolean;
};
export type UserMemberIndexProps = {
    request: UserMemberIndexRequest;
    users?: {
        data: Array<UserMemberIndexResource>;
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
export type UserMemberIndexResource = {
    id: number;
    first_name: string;
    last_name: string;
    full_name: string;
    email: string;
    phone?: string;
    can_view: boolean;
    can_update: boolean;
    can_trash: boolean;
    can_restore: boolean;
    can_delete: boolean;
    deleted_at?: string;
    avatar?: MediaResource | null;
};
export type UserMemberOneOrManyRequest = {
    user?: number;
    ids?: Array<number>;
};
export type UserResource = {
    id: number;
    owner_id: number;
    team_id?: number;
    first_name: string;
    last_name: string;
    full_name: string;
    email: string;
    phone?: string;
    is_admin: boolean;
    is_owner: boolean;
    is_member: boolean;
    avatar?: MediaResource;
    teams?: Array<TeamListResource>;
};
export type VerifyEmailProps = {};
export type VerifyEmailRequest = {
    code: string;
};
