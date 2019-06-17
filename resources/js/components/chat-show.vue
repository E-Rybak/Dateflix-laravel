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
                    <input type="text" name="message" v-model="message" required @keydown="tapParticipants">
                    <span v-if="activePeer" v-text="activePeer.username + ' is typing...'"></span>
                    <button class="btn btn-success">Send message</button>
                </form>
                <form @submit.prevent="deleteChat">
                    <button class="btn btn-danger">Delete chat permanently</button>
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
            this.username = this._username
        },
        data(){
            return {
                chat: {},
                message: '',
                username: '',
                activePeer: false,
                typingTimer: false
            }
        },
        methods: {
            ListenForNewMessage()
            {
                var channel = 'Chat.' + this.chat.id
                Echo.private(channel)
                .listen('SendMessage', (e) => {
                    this.chat.messages.push(e.message)
                    this.activePeer = false
                })
                .listenForWhisper('typing', e => {

                    this.activePeer = e;

                    if (this.typingTimer) //If a timer already exists, we clear the existing one and start a new one. This prevents the flashing messaging from happening.
                    {
                        clearTimeout(this.typingTimer)
                    }

                    this.typingTimer = setTimeout(() => {
                        this.activePeer = false
                    }, 1000)
                })
            },
            sendMessage()
            {
                Axios.post('http://127.0.0.1:8000/message', this.messageData)
                .catch((error) => {
                    console.log(error.message)
                });
                this.message = ''
            },
            deleteChat()
            {
                Axios.delete('http://127.0.0.1:8000/chat', { data: { chat_id: this.chat.id } })
                .then((response) => {
                    window.location.href = "http://127.0.0.1:8000/chat"
                })
                .catch((error) => {
                    console.log(error.message)
                });
            },
            tapParticipants()
            {
                var channel = 'Chat.' + this.chat.id
                Echo.private(channel)
                .whisper('typing', {
                    username: this.username
                })
            }
        },
        props: ['_chat', '_username'],
        computed: {
            messageData: function () {
                var data = { message: this.message, chat_id: this.chat.id }
                return data
            }
        }
    };
</script>
