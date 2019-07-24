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
				<p>Products</p>
			</template>
			<template slot="default">
				<ais-refinement-list
					attribute="products.name"
					operator="and"
					:searchable=true
					searchable-placeholder="Search products"
				/>
			</template>
		</ais-panel>

		<ais-panel>
			<template slot="header">
				<p>Users</p>
			</template>
			<template slot="default">
				<ais-refinement-list
					attribute="user_name"
					operator="or"
					:searchable=true
					searchable-placeholder="Search users"
				/>
			</template>
		</ais-panel>

		<ais-panel>
			<template slot="header">
				<p>Number of Saved</p>
			</template>
			<template slot="default">
				<ais-range-input attribute="saved_count" />
			</template>
		</ais-panel>
	</div>
</template>