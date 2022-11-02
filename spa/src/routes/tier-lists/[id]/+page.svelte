<script>
  export let data;

  const tierList = JSON.parse(data.tierList);
</script>

<svelte:head>
  <title>{tierList.name} - Tier lists</title>
  <meta name="description" content={`The tier list for ${tierList.name}.`} />
</svelte:head>

<div class="tier-list">
  <h1>{tierList.name}</h1>
  {#if tierList.description}
    <p>{tierList.description}</p>
  {/if}
  <h3>Ranks</h3>
  <div class="tier-list__ranks">
    {#each tierList.tierListRanks as tierListRank}
      <div class="tier-list__rank">
        <div class="tier-list__rank-name">{tierListRank.name}</div>
        <div class="tier-list__rank-items" />
      </div>
    {/each}
  </div>
</div>
