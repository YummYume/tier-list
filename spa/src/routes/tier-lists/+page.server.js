import { SECRET_API_HOST } from '$env/static/private';

/** @type {import('./$types').PageLoad} */
export async function load({ fetch }) {
    const tierLists = await fetch(`${SECRET_API_HOST}/api/spa/tier_lists`);

    return {
        tierLists: tierLists.json()
    };
}
