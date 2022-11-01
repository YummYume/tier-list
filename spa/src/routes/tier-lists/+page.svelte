<script>
	export let data;

	const tierLists = JSON.parse(data.tierLists);
</script>

<svelte:head>
	<title>Tier lists</title>
	<meta name="description" content="All of the tier lists." />
</svelte:head>

<div class="text-column">
	<h1>Tier Lists</h1>
	<ul>
		{#each tierLists as tierList}
			<li><a href={`/tier-lists/${tierList.id}`}>{tierList.name}</a></li>
		{/each}
	</ul>
</div>
