<template>
	<div>
		<ais-panel>
			<template slot="header">
				<p>Number of Products</p>
			</template>
			<template slot="default">
				<ais-range-input attribute="product_count" />
			</template>
		</ais-panel>
		
		<ais-panel>
			<template slot="header">
				<p>Number of Favorites</p>
			</template>
			<template slot="default">
				<ais-range-input attribute="fav_count" />
			</template>
		</ais-panel>
	</div>
</template>