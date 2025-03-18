import { HTMLAttributes, InputTypeHTMLAttribute } from 'vue';

export type InputProps = {
    type?: InputTypeHTMLAttribute;
    tabindex?: number;
    defaultValue?: string | number;
    modelValue?: string | number;
    class?: HTMLAttributes['class'];
};

export type InputEmits = {
    'update:modelValue': [string | number];
};
