import { FormDataType } from '@inertiajs/core';
import { InertiaForm } from '@inertiajs/vue3';
import { computed, ComputedRef } from 'vue';

/**
 * Splits a path string into segments, handling both dot notation and array bracket notation
 * Examples: 'deep' → ['deep'], 'list[0]' → ['list', '0'], 'deep.list[0].name' → ['deep', 'list', '0', 'name']
 */
type PathSegments<P extends string> = P extends `${infer First}[${infer Index}]${infer Rest}`
    ? Rest extends `.${infer AfterDot}`
        ? [...PathSegments<First>, Index, ...PathSegments<AfterDot>]
        : Rest extends ''
          ? [...PathSegments<First>, Index]
          : [...PathSegments<First>, Index, ...PathSegments<Rest>]
    : P extends `${infer First}.${infer RestPath}`
      ? [First, ...PathSegments<RestPath>]
      : [P];

/**
 * Extracts the nested type at a given path, handling both object and array access
 */
type GetNestedType<T, Segments extends string[]> = Segments extends [
    infer First extends string,
    ...infer Rest extends string[],
]
    ? First extends keyof T
        ? Rest extends []
            ? T[First]
            : GetNestedType<T[First], Rest>
        : T extends (infer U)[]
          ? First extends `${infer N extends number}`
              ? Rest extends []
                  ? U
                  : GetNestedType<U, Rest>
              : never
          : never
    : T;

/**
 * Recursively collects all paths from a type as union of dot-notation strings
 * Handles nested objects and arrays with numeric index notation
 */
type CollectErrorPaths<T, Prefix extends string = ''> = T extends object
    ? {
          [K in keyof T]: T[K] extends string
              ? Prefix extends ''
                  ? `${string & K}`
                  : `${Prefix}.${string & K}`
              : T[K] extends (infer U)[]
                ? U extends object
                    ?
                          | (Prefix extends '' ? `${string & K}` : `${Prefix}.${string & K}`)
                          | (Prefix extends '' ? `${string & K}[${number}]` : `${Prefix}.${string & K}[${number}]`)
                          | CollectErrorPaths<
                                U,
                                Prefix extends '' ? `${string & K}[${number}]` : `${Prefix}.${string & K}[${number}]`
                            >
                    : Prefix extends ''
                      ? `${string & K}`
                      : `${Prefix}.${string & K}`
                : T[K] extends object
                  ?
                        | (Prefix extends '' ? `${string & K}` : `${Prefix}.${string & K}`)
                        | CollectErrorPaths<T[K], Prefix extends '' ? `${string & K}` : `${Prefix}.${string & K}`>
                  : Prefix extends ''
                    ? `${string & K}`
                    : `${Prefix}.${string & K}`;
      }[keyof T]
    : never;

/**
 * Gets the flat error object type for a specific path
 */
type PathErrors<T> = {
    [K in CollectErrorPaths<T>]?: string;
};

export function useFormErrors<TForm extends FormDataType<TForm>, TPath extends string>(
    form: InertiaForm<TForm>,
    path: TPath,
): ComputedRef<PathErrors<GetNestedType<TForm, PathSegments<TPath>>>> {
    return computed(() => {
        const data: Record<string, string> = {};

        for (const [key, error] of Object.entries(form.errors) as Array<[string, string]>) {
            if (error.length === 0) continue;

            // Check if key starts with path followed by . or [
            if (key === path) {
                // Exact match - skip (error is for the field itself, not nested)
                continue;
            }

            if (key.startsWith(`${path}.`) || key.startsWith(`${path}[`)) {
                // Remove the path prefix and the following . or [
                const afterPath = key.slice(path.length);
                const strippedKey =
                    afterPath.startsWith('.') || afterPath.startsWith('[') ? afterPath.slice(1) : afterPath;

                if (strippedKey) {
                    data[strippedKey] = error;
                }
            }
        }
        return data as PathErrors<GetNestedType<TForm, PathSegments<TPath>>>;
    });
}
