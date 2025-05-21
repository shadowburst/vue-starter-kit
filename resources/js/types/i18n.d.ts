import { trans } from 'laravel-vue-i18n';

declare module '@vue/runtime-core' {
    interface ComponentCustomProperties {
        $t: typeof trans;
    }
}
