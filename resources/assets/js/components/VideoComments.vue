<template>
	<div>
		<p>{{comments.length}} {{ pluralizeComment(comments.length) }} </p>

		<div class="video-comment clearfix" v-if="signedIn">
			<textarea placeholder="Add a comment" class="form-control video-comment__input" v-model="body"></textarea>

			<div class="pull-right">
				<button type="submit" class="btn btn-default" @click.prevent="createComment">Post</button>
			</div>
		</div>

		<ul class="media-list">
			<li class="media" v-for="comment in comments">
				<div class="media-left">
					<a :href="'/channel/' + comment.channel.data.slug">
						<img v-bind:src="comment.channel.data.image" :alt=" comment.channel.data.name "  class="media-object">
					</a>
				</div>
				<div class="media-body">
					<a :href="'/channel/' + comment.channel.data.slug">{{ comment.channel.data.name }}</a> {{ comment.created_at_human }}
					<p>{{ comment.body }}</p>

					<ul class="list-inline" v-if="signedIn">
						<li>
							<a href="#" @click.prevent ="toggleReplyForm(comment.id)">{{ replyFormShow === comment.id ? 'Cancel' : 'Reply' }}</a>
						</li>

						<li>
							<a href="#" v-if="$root.user.id === comment.user_id" @click.prevent="deleteComment(comment.id)">Delete</a>
						</li>
					</ul>

					<div class="video-comment clear" v-if="replyFormShow === comment.id">
						<textarea class="form-control video-comment__input" v-model="replyBody"></textarea>
						<div class="pull-right">
							<button type="submit" class="btn btn-default" @click.prevent ="createReply(comment.id)">Reply</button>
						</div>
					</div>

					<div class="media" v-for="reply in comment.replies.data">
						<div class="media-left">
							<a :href="'/channel/' + reply.channel.data.slug ">
								<img v-bind:src="reply.channel.data.image" :alt=" reply.channel.data.name "  class="media-object">
							</a>
						</div>
						<div class="media-body">
							<a :href="'/channel/' + reply.channel.data.slug">{{ reply.channel.data.name }}</a> {{ reply.created_at_human }}
							<p>{{ reply.body }}</p>

							<ul class="list-inline" v-if="signedIn">
								<li>
									<a href="#" v-if="$root.user.id === reply.user_id" @click.prevent="deleteComment(reply.id)">Delete</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</li>
		</ul>
	</div>
</template>

<script>
	export default {
		data (){
			return {
				test: 'ok',
				comments: [],
				body: null,
				replyBody: null,
				replyFormShow: null
			}
		},
		props: {
			videoUid: null,

		},
        computed: {

            signedIn() {
                return window.pettube.signedIn;
            }
        },
		methods : {
			toggleReplyForm(commentId) {

				this.replyBody === null;

				if(this.replyFormShow === commentId){
					this.replyFormShow = null;
					return;
				}

				this.replyFormShow = commentId;
			},
			createReply (commentId) {
				this.$http.post('/videos/' + this.videoUid + '/comments', {
					body: this.replyBody,
					reply_id : commentId
				}).then((response) => {
										console.log(response);
					this.comments.map((comment, index) => {
						if(comment.id === commentId){
							this.comments[index].replies.data.push(response.body.data);
							return;
						}
					})
					this.replyBody =null,
					this.replyFormVisible = null;
				});
			},
			createComment () {
				this.$http.post('/videos/' + this.videoUid + '/comments', {
					body: this.body
				}).then((response) => {
					console.log(response);
					this.comments.unshift(response.body.data)
					 this.body = null;
				});
			},
			deleteComment (commentId) {
				if(!confirm('Do you want to delete this comment?')) {
					return;
				}

				
				this.$http.delete('/videos/'+ this.videoUid + '/comments/'+ commentId).then(() => {
					this.deleteById(commentId);
				});
			},

			deleteById (commentId) {
				this.comments.map((comment, index) => {
					if (comment.id === commentId) {
						this.comments.splice(index, 1);
						return;
					}

					comment.replies.data.map((reply, replyIndex) => {
						if(reply.id === commentId) {
							this.comments[index].replies.data.splice(replyIndex, 1);
							return;
						}
					})	
				});
			},
			getComments () {
				this.$http.get('/videos/' + this.videoUid + '/comments').then((response) => {
						
						//console.log(response);
						this.comments = response.body.data;

				});
			},


			pluralizeComment (count) {
				  if (count === 0) {
				    return 'comment'
				  } else if (count === 1) {
				    return 'comment'
				  } else {
				    return 'comments'
				  }
			}	
		},
		ready () {

			
		},
		mounted() {
			this.getComments();
		}

	}
</script>