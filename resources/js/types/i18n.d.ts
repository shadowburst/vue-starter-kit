import { trans, transChoice } from 'laravel-vue-i18n';

declare module '@vue/runtime-core' {
    interface ComponentCustomProperties {
        $t: typeof trans;
        $transChoice: typeof transChoice;
    }
}
