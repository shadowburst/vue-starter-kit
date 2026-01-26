import { trans, transChoice } from 'laravel-vue-i18n';
import { ToastMessagesData } from './backend';
import { AppPageProps } from './inertia';

declare module '@inertiajs/core' {
    export interface InertiaConfig {
        flashDataType: {
            toast?: ToastMessagesData;
        };
    }
}

declare module '@vue/runtime-core' {
    interface ComponentCustomProperties {
        $inertia: typeof Router;
        $page: Page;
        $headManager: ReturnType<typeof createHeadManager>;
    }
}

declare module '@vue/runtime-core' {
    interface ComponentCustomProperties {
        $t: typeof trans;
        $transChoice: typeof transChoice;
    }
}
