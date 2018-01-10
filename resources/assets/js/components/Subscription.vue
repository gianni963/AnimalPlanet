<template>
	<div v-if="subscribers !==null">
		 {{ subscribers }} {{ pluralizeFollower(subscribers.length) }} &nbsp;
		 <button class="btn btn-xs btn-default" type="button" v-if="canSubscribe" @click.prevent="handle">{{ userSubscribed ? 'Unsubscribe' : 'Subscribe'}}</button>
	</div>
</template>

<script>
	export default {

		data() {
			return {

				subscribers : null,
				userSubscribed : null,
				canSubscribe : false,
			}
		},
		props: {

			channelSlug: null

		},
		methods: {

			getSubscriptionStatus() {
				this.$http.get('/subscriptions/' + this.channelSlug).then((response) => {
					this.subscribers = response.body.data.count;
					this.userSubscribed = response.body.data.user_subscribed;
					this.canSubscribe = response.body.data.can_subscribe;
				});
			},
			handle () {
				if(this.userSubscribed) {
					this.unsubscribe();
				} else {
					this.subscribe();
				}
			},

			subscribe () {
				this.userSubscribed = true;
				this.subscribers++;

				this.$http.post('/subscriptions/' + this.channelSlug);
			},

			unsubscribe () {
				this.userSubscribed = false;
				this.subscribers--;

				this.$http.delete('/subscriptions/' + this.channelSlug);
			},
			
			pluralizeFollower (count) {
			  if (count === 0) {
			    return 'follower'
			  } else if (count === 1) {
			    return 'follower'
			  } else {
			    return 'followers'
			  }
			}	
		},

		ready () {
			
		},
		mounted () {
			
			this.getSubscriptionStatus();
		}
	}
</script>