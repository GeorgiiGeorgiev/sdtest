<template>
    <div class="container-fluid">
        <div v-for="post in posts" v-bind:key="post.id" class="card-panel hoverable">
            <div>
                <h4>Пост №{{ post.id }}</h4>
            </div>
            <div>
                <h5>Содержание</h5>
                <blockquote>{{ post.text }}</blockquote>
            </div>
            <div>
                <h5>Комментарии</h5>
                <Comments v-bind:comments="post.comments" v-bind:post="post" v-bind:level="1"></Comments>
            </div>
        </div>
    </div>
</template>

<script>
	export default {
        name: "PostsComponent",
        props:
            {
                posts: Array,
            },
		created()
		{
			this.fetchPosts();
		},
		methods:
            {
                fetchPosts()
                {
                    fetch('api/posts')
                    .then(response => response.json())
                    .then(response => {
                        this.posts = response.data;
                    });
                },
            }
	}
</script>
