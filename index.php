<!DOCTYPE html>
<html>
<head>
	<title>FRONT END</title>
	<link rel="stylesheet" type="text/css" href="vendor/css/boostrap.css">
	<script type="text/javascript" src="vendor/js/es6-promise-auto.js"></script>
	<script type="text/javascript" src="vendor/js/vue.js"></script>
	<script type="text/javascript" src="vendor/js/vuex.js"></script>
	<script type="text/javascript" src="vendor/js/vue-resource.js"></script>
	<style type="text/css">
		.custom-modal-show {
			display: block;
			background: rgba(255, 255, 255, 0.8);
		}
	</style>
</head>
<body>
	<div id="app">
		<center><h1>Restaurant App</h1></center>
		<div class="container">
			<table class="table table-striped">
			  <thead>
			    <tr>
			      <th scope="col">No.</th>
			      <th scope="col">Restaurant</th>
			      <th scope="col">Description</th>
			      <th scope="col">Action</th>
			    </tr>
			  </thead>
			  <tbody>
			    <tr v-for="restaurant in restaurants">
			      <th scope="row">{{ restaurant.id }}</th>
			      <td>{{ restaurant.name }}</td>
			      <td>{{ restaurant.cuisines }}</td>
			      <td><button type="button" class="btn btn-primary" @click="showRestaurant(restaurant)">Lihat Menu</button></td>
			    </tr>
			  </tbody>
			</table>
		</div>

		<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" :class="{'show': modalShown, 'custom-modal-show': modalShown}">
		  <div class="modal-dialog modal-lg">
		    <div class="modal-content">

		      <div class="modal-header">
		        <h5 class="modal-title h4" id="myLargeModalLabel">{{ activeRestaurant.name }}</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="modalShown = !modalShown">
		          <span aria-hidden="true">×</span>
		        </button>
		      </div>

		      <div class="modal-body">
		      	<div class="card mb-3">
				  <img :src="activeRestaurant.image" class="card-img-top" alt="..." height="200px" style="object-fit: contain;">
				</div>
				<ul class="list-group">
				  <li class="list-group-item">No menu available</li>
				</ul>
		      </div>

		    </div>
		  </div>
		</div>

	</div>
	<script type="text/javascript">
		Vue.use(Vuex);
			const store = new Vuex.Store({
				state: {
					restaurants: [],
					activeRestaurant: {
						id: "",
						name: "",
						image: "",
						menus: [],
					}
				},
				mutations: {
					addRestaurant: function(state, restaurant){
						state.restaurants.push(restaurant);
					},
					setActiveRestaurant: function(state, restaurant){
						state.activeRestaurant.id = restaurant.id;
						state.activeRestaurant.name = restaurant.name;
						state.activeRestaurant.image = restaurant.thumb;
					}
				}
			});
		(function(){

			new Vue({
				el: "#app",
				data:{
					modalShown: false,
				},
				methods: {
					grabDataRestaurant: function() {
						this.$http.get('/data.php').then(
							function(data){
								for(restaurant of data.data.restaurants) {
									store.commit('addRestaurant', restaurant.restaurant);
								}
							},
							function(error){
								console.log(error);
							}
						);
					},
					showRestaurant: function(restaurant) {
						store.commit('setActiveRestaurant', restaurant);
						this.modalShown = !this.modalShown;
					},
					grabRestaurantMenu: function(restaurant){
						this.$http.get('/')
					}
				},
				computed: {
					restaurants: function(){
						return store.state.restaurants;
					},
					activeRestaurant: function(){
						return store.state.activeRestaurant;
					}
				},
				mounted: function(){
					this.grabDataRestaurant();
				}
			});
		})();
	</script>

</body>
</html>
