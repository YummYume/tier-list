import { error } from '@sveltejs/kit';
import { SECRET_API_HOST } from '$env/static/private'

/** @type {import('./$types').PageLoad} */
export async function load({ fetch, params }) {
    const tierList = await fetch(`${SECRET_API_HOST}/api/spa/tier_lists/${params.id}`);

    if (404 === tierList.status) {
        throw error(404, 'Not Found');
    }

    return {
        tierList: tierList.json()
    };
}
