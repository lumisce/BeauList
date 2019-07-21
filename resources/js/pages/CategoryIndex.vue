<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">Categories</div>
						<div class="row m-0">
							<div class="border-right" style="width:40%;">
								<div class="list-group list-group-flush">
									<a v-for="(parent, index) in parents" 
										class="list-group-item list-group-item-action" 
										:class="{'active': activeParent == parent.id}" 
										@click.prevent="showChildren(parent.id)">
										{{parent.name}}
									</a>
								</div>
							</div>
							<div style="width:60%;">
								<div class="tab-content">
									<div v-for="(children, parentId, index) in childrenGroup" 
										class="tab-pane list-group-flush" 
										:class="{'active': activeParent == parentId}">
										<router-link v-for="(child, index) in children" 
											:to="{ name: 'categories.show', params: {id: child.id} }" 
											:key="child.id" class="list-group-item" 
											:class="{'border-top-0': index == 0}">
											{{child.name}}
										</router-link>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				parents: [],
				childrenGroup: {},
				activeParent: 1
			}
		},
		methods: {
			showChildren(id) {
				this.activeParent = id
			}
		},
		created() {
			this.axios.get('/api/categories').then(response => {
				this.parents = response.data.items;
				this.childrenGroup = response.data.children;
			});
		}
	}
</script>