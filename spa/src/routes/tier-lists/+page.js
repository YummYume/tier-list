/** @type {import('./$types').PageLoad} */
export async function load({ fetch }) {
    const tierLists = await fetch('https://nginx/api/spa/tier_lists');

    return {
        tierLists
    };
}
