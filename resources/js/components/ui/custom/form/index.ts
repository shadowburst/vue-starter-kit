export { FieldSeparator as FormSeparator } from '@/components/ui/field';
export { default as Form, injectFormContext } from './Form.vue';
export { default as FormActions } from './FormActions.vue';
export { default as FormContent } from './FormContent.vue';
export { default as FormControl } from './FormControl.vue';
export { default as FormDescription } from './FormDescription.vue';
export { default as FormError } from './FormError.vue';
export { default as FormField, injectFormFieldContext, type FormFieldProps } from './FormField.vue';
export { default as FormLabel } from './FormLabel.vue';
export { default as FormSubmitButton } from './FormSubmitButton.vue';

export type FormProps = {
    autofocus?: boolean;
    disabled?: boolean;
};
