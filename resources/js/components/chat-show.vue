<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ chat.name }}</div>

                <div class="card-body">

                    <h6><b>Participants</b></h6>
                    <ol>
                        <li v-for="user in chat.users">
                            {{ user.name }}
                        </li>
                    </ol>
                    <h6><b>Messages</b></h6>   
                    <ul>
                        <li v-for="message in chat.messages">
                            {{ message.body }}
                        </li>
                    </ul>
                </div>
                <form @submit.prevent="sendMessage">
                    <input type="text" name="message" v-model="message" required>
                    <input type="hidden" name="chat_id" :value="chat.id">
                    <button class="btn btn-success">Send message</button>
                </form>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
import Axios from 'axios'
    export default {
        mounted() {
            console.log('Chat-show.vue mounted.')
            this.chat = JSON.parse(this._chat)
            this.ListenForNewMessage()
        },
        data(){
            return {
                chat: {},
                message: '',
            }
        },
        methods: {
            ListenForNewMessage()
            {
                var channel = 'Chat.' + this.chat.id
                Echo.private(channel)
                .listen('SendMessage', (e) => {
                    this.chat.messages.push(e.message)
                });
            },
            sendMessage()
            {
                Axios.post('http://127.0.0.1:8000/message', this.formData)
                .catch((error) => {
                    console.log(error.message)
                });
            }
        },
        props: ['_chat'],
        computed: {
            formData: function () {
                var data = { message: this.message, chat_id: this.chat.id }
                return data;
            }
        }
    };
</script>
