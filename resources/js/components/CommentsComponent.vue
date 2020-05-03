<template>
    <div>
        <div v-if="level == 1">
            <form @submit.prevent="actionAdd()">
                <div class="input-field col s12">
                    <label>Добавить комментарий</label>
                    <textarea class="materialize-textarea" v-model="newComment.text"></textarea>
                </div>
                <button type="submit" class="waves-effect waves-light btn-small light-blue darken-3">Сохранить</button>
            </form>
        </div>
        <div v-if="comments.length > 0">
            <div v-for="(comment,index) in comments" v-bind:key="comment.id">
                <div class="card-panel row hoverable" v-bind:style="{ paddingLeft: (comment.nesting_level * 1) + 'rem' }">
                    <div class="col s7">
                        <label>
                            <div>№{{ comment.id }}</div>
                            <div>{{ comment.created }}</div>
                            <div v-if="comment.parent">
                                <span>Ответ на сообщение №{{ comment.parent.id }}: {{ comment.parent.text }}</span>
                            </div>
                        </label>
                        <form @submit.prevent="actionEdit(comment,index)">
                            <textarea class="materialize-textarea" v-model="comment.text">{{ comment.text }}</textarea>
                            <button type="submit" class="waves-effect waves-light btn-small light-green accent-4">Изменить</button>
                            <button type="button" class="waves-effect waves-light btn-small deep-orange darken-2" @click="actionDelete(comment,index)">Удалить</button>
                        </form>
                    </div>

                    <div class="col s5">
                        <form @submit.prevent="actionReply(comment,index)" class="card grey lighten-3">
                            <div class="card-content white-text">
                                <label>Написать ответ</label>
                                <textarea class="materialize-textarea" v-model="comment.reply.text"></textarea>
                            </div>
                            <div class="card-action">
                                <button type="submit" class="waves-effect waves-light btn-small blue-grey">Ответить</button>
                            </div>
                        </form>
                    </div>

<!--                    <div class="col s5">-->
<!--                        <form @submit.prevent="actionReply(comment,index)">-->
<!--                            <div class="input-field col s12">-->
<!--                                <label>Написать ответ</label>-->
<!--                                <textarea  class="materialize-textarea" v-model="comment.reply.text"></textarea>-->
<!--                            </div>-->
<!--                            <button type="submit" class="waves-effect waves-light btn-small blue-grey">Ответить</button>-->
<!--                        </form>-->
<!--                    </div>-->

                    <div class="col s12" v-if="comment.childs.length > 0">
                        <Comments v-bind:comments="comment.childs" v-bind:post="post" v-bind:level="comment.nesting_level + 1"></Comments>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <p class="center-align">Нет комментариев</p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CommentsComponent",
        props:
        {
            comments: Array,
            post: Object,
            level: Number,
        },
        created()
        {
        },
        data()
        {
        	return {
                newComment: {
                    id: '',
                    text: '',
                    post_id: this.post.id,
                    comment_id: '',
                    nesting_level: 1,
                    index: '',
                },
                replyComment: {
                    id: '',
                    text: '',
                    post_id: this.post.id,
                    comment_id: '',
                    nesting_level: 1,
                    index: '',
                },
        	};
        },
        methods:
            {
                resetComment()
                {
                    this.newComment.id = '';
                    this.newComment.text = '';
                    this.newComment.post_id = this.post.id;
                    this.newComment.comment_id = '';
                    this.newComment.nesting_level = 1;
                    this.newComment.index = '';

                    this.replyComment.id = '';
                    this.replyComment.text = '';
                    this.replyComment.post_id = this.post.id;
                    this.replyComment.comment_id = '';
                    this.replyComment.nesting_level = 1;
                    this.replyComment.index = '';
                },
                actionEdit(comment,index)
                {
                    if (comment.text.length < 1) {
                        alert ('Нельзя отправить пустой комментарий...');
                        return;
                    }

                    fetch(`api/comments/${comment.id}`, {
                        method: 'PUT',
                        body: JSON.stringify(comment),
                        headers: {
                            'content-type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.hasOwnProperty('errors') && data.errors.length > 0) {
                            let errorText = '';
                            for (let error in data.errors) {
                                errorText += data.errors[error] + '<br>';
                            }
                            alert(errorText);
                        } else {
                            alert('Комментарий изменён');
                            this.$set(this.comments, index, data);
                        }
                    });
                },
                actionReply(comment,index)
                {
                    if (comment.text.length < 1) {
                        alert ('Нельзя отправить пустой комментарий...');
                        return;
                    }

                    //this.replyComment = Object.assign({}, data.comment);
                    this.replyComment.nesting_level += comment.nesting_level;
                    this.replyComment.comment_id = comment.id;
                    this.replyComment.text = comment.reply.text;

                    fetch('api/comments',{
                        method: 'POST',
                        body: JSON.stringify(this.replyComment),
                        headers: {
                            'content-type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.hasOwnProperty('errors') && data.errors.length > 0) {
                            let errorText = '';
                            for (let error in data.errors) {
                                errorText += data.errors[error] + '<br>';
                            }
                            alert(errorText);
                        } else {
                            alert('Ответ добавлен');
                            this.comments[index].childs.unshift(data);
                            this.resetComment();
                            comment.reply.text = '';
                        }
                    });
                },
                actionDelete(comment,index)
                {
                    if (confirm('Вы уверены что хотите удалить комментарий?')) {
                        fetch(`api/comments/${comment.id}`,{
                            method: 'delete',
                        })
                        .then(response => {
                            alert('Комментарий удалён');
                            this.$delete(this.comments, index);
                        })
                        .catch(error => console.log(error));
                    }
                },
                actionAdd()
                {
                    if (this.newComment.text.length < 1) {
                        alert ('Нельзя отправить пустой комментарий...');
                        return;
                    }

                    fetch('api/comments', {
                        method: 'POST',
                        body: JSON.stringify(this.newComment),
                        headers: {
                            'content-type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.hasOwnProperty('errors') && data.errors.length > 0) {
                            let errorText = '';
                            for (let error in data.errors) {
                                errorText += data.errors[error];
                            }
                            alert(errorText);
                        } else {
                            alert('Комментарий добавлен');
                            this.comments.unshift(data);
                            this.resetComment();
                        }
                    });
                }
            }
    }
</script>

<style scoped>

</style>
