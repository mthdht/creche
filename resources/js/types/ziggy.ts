import { Config, RouteParams } from 'ziggy-js';
import { usePage } from '@inertiajs/vue3'


const Page = usePage();

declare global {
    function route(): Config;
    function route(name: string, params?: RouteParams<typeof name> | undefined, absolute?: boolean): string;
}

declare module '@vue/runtime-core' {
    interface ComponentCustomProperties {
        route: typeof route;
        $page: typeof Page;
    }
}
