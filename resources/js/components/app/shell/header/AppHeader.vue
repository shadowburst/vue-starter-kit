<script setup lang="ts">
import AppLogo from '@/components/app/AppLogo.vue';
import Breadcrumbs from '@/components/app/shell/Breadcrumbs.vue';
import UserDropdownMenuContent from '@/components/app/shell/UserDropdownMenuContent.vue';
import UserAvatar from '@/components/app/user/UserAvatar.vue';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import {
    NavigationMenu,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    navigationMenuTriggerStyle,
} from '@/components/ui/navigation-menu';
import { Sheet, SheetContent, SheetHeader, SheetTitle, SheetTrigger } from '@/components/ui/sheet';
import { useAuth } from '@/composables';
import type { BreadcrumbItem, NavItem, SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { LayoutGridIcon, Menu, Search } from 'lucide-vue-next';
import { computed } from 'vue';

type Props = {
    breadcrumbs?: BreadcrumbItem[];
};
const { breadcrumbs = [] } = defineProps<Props>();

const page = usePage<SharedData>();
const auth = useAuth();

const isCurrentRoute = computed(() => (url: string) => page.props.ziggy.url === url);

const activeItemStyles = computed(
    () => (url: string) =>
        isCurrentRoute.value(url) ? 'text-neutral-900 dark:bg-neutral-800 dark:text-neutral-100' : '',
);

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: route('home'),
        icon: LayoutGridIcon,
    },
];
</script>

<template>
    <div>
        <div class="border-b border-sidebar-border/80">
            <div class="mx-auto flex h-16 items-center px-4 md:max-w-7xl">
                <!-- Mobile Menu -->
                <div class="lg:hidden">
                    <Sheet>
                        <SheetTrigger as-child>
                            <Button class="mr-2 size-9" variant="ghost" size="icon">
                                <Menu class="size-5" />
                            </Button>
                        </SheetTrigger>
                        <SheetContent class="w-[300px] p-6" side="left">
                            <SheetTitle class="sr-only">Navigation Menu</SheetTitle>
                            <SheetHeader class="flex justify-start text-left">
                                <AppLogoIcon class="size-6 fill-current text-black dark:text-white" />
                            </SheetHeader>
                            <div class="flex h-full flex-1 flex-col justify-between space-y-4 py-6">
                                <nav class="-mx-3 space-y-1">
                                    <Link
                                        class="flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium hover:bg-accent"
                                        v-for="item in mainNavItems"
                                        :key="item.title"
                                        :href="item.href"
                                        :class="activeItemStyles(item.href)"
                                    >
                                        <component class="size-5" v-if="item.icon" :is="item.icon" />
                                        {{ item.title }}
                                    </Link>
                                </nav>
                            </div>
                        </SheetContent>
                    </Sheet>
                </div>

                <Link class="flex items-center gap-x-2" :href="route('home')">
                    <AppLogo />
                </Link>

                <!-- Desktop Menu -->
                <div class="hidden h-full lg:flex lg:flex-1">
                    <NavigationMenu class="ml-10 flex h-full items-stretch">
                        <NavigationMenuList class="flex h-full items-stretch space-x-2">
                            <NavigationMenuItem
                                class="relative flex h-full items-center"
                                v-for="(item, index) in mainNavItems"
                                :key="index"
                            >
                                <Link :href="item.href">
                                    <NavigationMenuLink
                                        :class="[
                                            navigationMenuTriggerStyle(),
                                            activeItemStyles(item.href),
                                            'h-9 cursor-pointer px-3',
                                        ]"
                                    >
                                        <component class="mr-2 size-4" v-if="item.icon" :is="item.icon" />
                                        {{ item.title }}
                                    </NavigationMenuLink>
                                </Link>
                                <div
                                    class="absolute bottom-0 left-0 h-0.5 w-full translate-y-px bg-black dark:bg-white"
                                ></div>
                            </NavigationMenuItem>
                        </NavigationMenuList>
                    </NavigationMenu>
                </div>

                <div class="ml-auto flex items-center space-x-2">
                    <div class="relative flex items-center space-x-1">
                        <Button class="group size-9 cursor-pointer" variant="ghost" size="icon">
                            <Search class="size-5 opacity-80 group-hover:opacity-100" />
                        </Button>
                    </div>

                    <DropdownMenu>
                        <DropdownMenuTrigger as-child>
                            <Button
                                class="relative size-10 w-auto rounded-full p-1 focus-within:ring-2 focus-within:ring-primary"
                                variant="ghost"
                                size="icon"
                            >
                                <UserAvatar class="size-8 overflow-hidden rounded-full" :user="auth.user" />
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent class="w-56" align="end">
                            <UserDropdownMenuContent />
                        </DropdownMenuContent>
                    </DropdownMenu>
                </div>
            </div>
        </div>

        <div class="flex w-full border-b border-sidebar-border/70" v-if="breadcrumbs.length > 1">
            <div class="mx-auto flex h-12 w-full items-center justify-start px-4 text-neutral-500 md:max-w-7xl">
                <Breadcrumbs :breadcrumbs />
            </div>
        </div>
    </div>
</template>
