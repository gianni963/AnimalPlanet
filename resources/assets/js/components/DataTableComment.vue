<template>
	<div class="panel panel-default">
		<div class="panel-heading">
			{{ response.table }}
			<a href="#" class="pull-right" v-if="response.allow.creation" @click.prevent="creating.active = !creating.active">
				{{ creating.active ? 'Cancel' : 'New record' }}
			</a>
		</div>

		<div class="panel-body">
			<div class="well" v-if="creating.active">
				<form action="#" class="form-horizontal" @submit.prevent="store">
					<div class="form-group" v-for="column in response.updatable" :class="{ 'has-error':creating.errors[column] }">
						<label class="col-md-3 control-label" :for="column">{{ response.custom_columns[column] || column }}</label>
						<div class="col-md-6">
							<input type="text" :id="column" class="form-control" v-model="creating.form[column]">
							<span class="help-block" v-if="creating.errors[column]">
								<strong>{{ creating.errors[column][0] }}</strong>
							</span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6 col-md-offset-3">
							<button type="Submit" class="btn btn-default">Create</button>
						</div>
					</div>

					
				</form>
			</div>
			<form action="#" @submit.prevent="getRecords">
				<label for="search">Search</label>
				<div class="row row-fluid">
					<div class="form-group col-md-3">
						<select class="form-control" v-model="search.column">
							<option :value="column" v-for="column in response.displayable">
								{{ column }}
							</option>
						</select>
					</div>
					<div class="form-group col-md-3">
						<select class="form-control" v-model="search.operator">
							<option value="equals">=</option>
							<option value="contains">contains</option>
							<option value="starts_with">starts with</option>
							<option value="ends_with">ends with</option>
							<option value="greater_than">></option>
							<option value="less_than"><</option>
						</select>
					</div>
					<div class="form-group col-md-6">
						<div class="input-group">
							<input type="text" name="" id="search" v-model="search.value" class="form-control">
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit">Search</button>
							</span>
						</div>
						
					</div>
				</div>
			</form>
			<div class="row">
				<div class="form-group col-md-8">
					<label for="filter">Search</label>
					<input type="text" id="filter" class="form-control" v-model="quickSearch">
				</div>				
				<div class="form-group col-md-4">
					<label for="limit">Display records</label>
					<select id="limit" class="form-control" v-model="limit" @change="getRecords">
						<option value="50">50</option>
						<option value="100">100</option>
						<option value="250">250</option>
						<option value="">All records</option>
					</select>
				</div>
			</div>
				
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th v-for="column in response.displayable">
								<span  class="sortable" @click="sortBy(column)">
									{{ response.custom_columns[column] ||  column }}
								</span>
								<span 
									class="arrow" 
									v-if="sort.key === column"
									:class="{ 'arrow--asc': sort.order === 'asc', 'arrow--desc' : sort.order === 'desc' }"
								>
									
								</span>
							</th>
							<th>&nbsp;</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>

						<tr v-for="record in filteredRecords">
							<td v-for="columnValue, column in record">
								<template v-if="editing.id === record.id && isUpdatable(column)">
									<div class="form-group" :class="{'has-error': editing.errors[column] }">
										<input type="text" class="form-control" :value="columnValue" v-model="editing.form[column]">
										<span class="help-block" v-if="editing.errors[column]">
											<strong>{{ editing.errors[column][0] }}</strong>
										</span>
									</div>
								</template>
								<template v-else>
									{{ columnValue}}
								</template>

							</td>
							<td>
								<a href="#" @click.prevent="edit(record)" v-if="editing.id !== record.id">Edit</a>
								<template v-if="editing.id === record.id">
									<a href="#" @click.prevent="update">Save</a><br>
									<a href="#" @click.prevent="editing.id = null">Cancel</a>
								</template>
								
							</td>
							<td>
								<a href="#" @click.prevent="destroy(record.id)" v-if="response.allow.deletion">Delete</a>
							</td>
						</tr>
					</tbody>
				</table>

			</div>
		</div>
	</div>
</template>

<script>
	import queryString from 'query-string'
	export default {
		props: ['endpoint'],
		data () {
			return {
				response: {
					table: '',
					displayable: [],
					records: [],
					allow: {}
				},
				sort: {
					key: 'id',
					order: 'asc'
				},
				limit: 50,
				quickSearch: '',
				editing: {
					id: null,
					form: {},
					errors: []
				},
				search: {
					value: '',
					operator: 'equals',
					column: 'id'
				},
				creating: {
					active: false,
					form: {},
					errors: []
				}
			}
		},
		computed: {
			filteredRecords () {
				let data = this.response.records

				data = data.filter((row) => {
					return Object.keys(row).some((key) => {
						return String(row[key]).toLowerCase().indexOf(this.quickSearch.toLowerCase()) > -1
					})
				}) 

				if (this.sort.key) {
					data = _.orderBy(data, (i) => {
						let value = i[this.sort.key]

						if (!isNaN(parseFloat(value))) {
							return parseFloat(value)
						}

						return String(i[this.sort.key]).toLowerCase()
					}, this.sort.order)

					return data
				}
			}
		},
		methods: {
			getRecords () {
				return axios.get(`${this.endpoint}?${this.getQuery()}`).then((response) => {
					this.response = response.data.data
				})
			},

			getQuery () {
				return queryString.stringify({
					limit: this.limit,
					...this.search

				})
			},

			sortBy (column) {
				this.sort.key = column
				this.sort.order = this.sort.order === 'asc' ? 'desc' : 'asc'
			},

			edit (record) {
				this.editing.errors = []
				this.editing.id = record.id
				this.editing.form = _.pick(record, this.response.updatable);
			},

			isUpdatable (column) {
				return this.response.updatable.includes(column)
			},

			update () {
				axios.patch(`${this.endpoint}/${this.editing.id}`, this.editing.form).then(() => {
					this.getRecords().then(() => {
						this.editing.id = null
						this.editing.form = {}
					})
				}).catch((error) => {
					if (error.response.status === 422) {
						this.editing.errors = error.response.data.errors
					}
				})
			},

			store  () {
				axios.post(`${this.endpoint}`, this.creating.form).then(() => {
					this.getRecords().then(() => {
						this.creating.active = false
						this.creating.form = {}
						this.creating.errors = []
					})
				}).catch((error) => {
					if (error.response.status === 422) {
						this.creating.errors = error.response.data.errors
					}
				})
			},

			destroy (record) {
				if (!window.confirm(`Are you sure you want to delete it?`)){
					return;
				}
				axios.delete(`${this.endpoint}/${record}`).then(() =>{
					this.getRecords()
				})
			},

		},

		mounted () {
			this.getRecords()
		},
		ready () {
		
		}

	}
</script>

<style lang="scss">
	.sortable {
		cursor: pointer;
	}

	.arrow {
		display: inline-block;
		vertical-align: middle;
		width: 0;
		height: 0;
		margin-left: 5px;
		opacity: .6;

		&--asc {
			border-left: 4px solid transparent;
			border-right: 4px solid transparent;
			border-bottom: 4px solid #222;
		}

		&--desc {
			border-left: 4px solid transparent;
			border-right: 4px solid transparent;
			border-top: 4px solid #222;
		}
	}

</style>