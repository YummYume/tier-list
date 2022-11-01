<script>
	export let data;

	const tierList = JSON.parse(data.tierList);
</script>

<svelte:head>
	<title>{tierList.name} - Tier lists</title>
	<meta name="description" content={`The tier list for ${tierList.name}.`} />
</svelte:head>

<div class="text-column">
	<h1>{tierList.name}</h1>
	{#if tierList.description}
		<p>{tierList.description}</p>
	{/if}
	<h3>Ranks</h3>
	<ul>
		{#each tierList.tierListRanks as tierListRank}
			<li>{tierListRank.name}</li>
		{/each}
	</ul>
</div>
