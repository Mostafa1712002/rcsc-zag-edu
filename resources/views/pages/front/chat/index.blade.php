@extends('pages.front.master')
@section('content')
<section class="search" x-data>
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-7">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                       <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('site.home')</a></li>
                        <li class="breadcrumb-item"><img src="{{asset('front/assets')}}/images/bread-arrow.png" alt=""></i></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$page_title}}</li>
                    </ol>
                    </nav>
            </div>
            <div class="col-lg-3 col-md-1"> </div>
            <div class="col-lg-2 col-md-3">
                <div class="d-grid gap-2">
                    <x-create-ad-button/>
                </div>

            </div>
        </div>
        <div class="row">

            <div class="col-lg-12  mt-4">
                <div class="row">
                    <div class="notif-card col-lg-4 col-md-6">
                        <ul class="filter-2 float-start">

                            <li>
                                <div class="navbar">
                                    <div class="dropdown">
                                        {{-- <button class="btn  btn-3 btn-33 dropdown-toggle border rounded" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            ترتيب حسب

                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item" href="#">Action</a></li>
                                            <li><a class="dropdown-item" href="#">Another action</a></li>
                                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                                        </ul> --}}
                                    </div>
                                </div>
                            </li>
                            {{-- <li><a href="#" class="btn btn-1 btn-33 text-center"><img src="{{asset('front/assets')}}/images/search.png" alt=""></a></li> --}}


                        </ul>
                        <h5 class="simler-add simler-add-2 pe-4">
                            @lang('site.message')
                            <small x-text="$store.all_chats.unread_count? $store.all_chats.unread_count : ''"></small>
                        </h5>
                        <div class="clearfix"></div>

                        <div
                            x-data
                            x-init="$store.all_chats.loadItems();"
                            class="chat-scroll">
                            <template x-for="item in $store.all_chats.itemsSorted">
                                <div class="comment-box" x-on:click="$store.current_chat.setCurrentCustomerId(item.other_customer.key)">
                                    <div class="comment-card border-active border-active-2 p-3">
                                        <h6 class="float-start pt-3">
                                            <span class="badge bg-active bg-active-2" x-text="item.unread_count? item.unread_count : ''"></span>
                                        </h6>

                                        <div class="comment comment-2 comment-22">
                                            <img :src="item.other_customer.avatar" alt="" class="float-end">
                                            <div class="pe-5">
                                                <h3 x-text="customerName(item.other_customer.name)"></h3>
                                                <h4>
                                                    <span x-text="item.last_message.content"></span>
                                                    <small x-text="item.last_message.created_at"></small>
                                                </h4>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </template>

                        </div>
                    </div>
                    <div class="chat-box col-lg-8 col-md-6">
                        <div  class="comment-box border rounded">
                            <div class="chat-head ">
                                <img src="{{asset('front/assets')}}/images/comment-per.png" alt="" class="float-end">
                                <div class="pe-5">
                                    <h3 x-text="$store.current_chat.current_customer.name"></h3>
                                    <h4><small x-text="$store.current_chat.onlineStatus"></small></h4>
                                </div>
                            </div>

                            <!-- Start active conversation-->
                            <div class="chat-body p-3">
                                <button
                                    x-data
                                    x-on:click='$store.current_chat.getMoreMessages()'
                                    x-show="$store.current_chat.show_load_more"
                                    class="btn">
                                        Load more
                            </button>

                                <template x-for="message in $store.current_chat.messages" :key="message.id">
                                    <div :class="message.customer1_id == {{auth('customer')->id()}} ? 'sender float-start' :  'resiver'"  style='clear:both'>
                                        <img x-show="message.image!=null" :src="message.image"/>
                                        <h5 x-text="message.content"></h5>
                                    </div>

                                    {{-- <div class="clearfix"></div> --}}
                                </template>
                            </div><!-- End active conversation-->


                            <!-- Send message -->
                            <div class="row mb-3">
                                <div class="col-10">
                                    <div class="input-group border rounded me-3">
                                        <textarea
                                            :class="$store.current_chat.is_disabled? 'is-invalid' : '' "
                                            x-model="$store.current_chat.message"
                                            x-on:input="$store.current_chat.messageCheck()"
                                            class="form-control form-control0"
                                            aria-label="With textarea"
                                            placeholder="@lang('site.write_your_message_here')">
                                        </textarea>

                                        <p>
                                            @lang('site.remaining_chars') : <span x-text="$store.current_chat.remaining_chars"></span>
                                        </p>

                                        <div class="input-group-prepend">
                                            <a
                                            :disabled="$store.current_chat.is_disabled"
                                            x-on:click="$store.current_chat.sendMessage()"
                                            class="input-group-text btn btn-1 btn-11">
                                                <img src="{{asset('front/assets')}}/images/send.png" alt="">
                                            </a>
                                        </div>
                                        </div>
                                </div>
                                <div class="col-2 text-center">
                                    <img src="{{asset('front/assets')}}/images/attach.png" alt="" class="mt-2">
                                </div>
                            </div><!-- Send message -->

                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    function customerName(name){
        return name.length>25? name.substring(0,25)+' ...' : name;
    }

    document.addEventListener('alpine:init', () => {

        window.Alpine.store('current_chat', {
            current_customer:{},
            show_load_more:false,
            chat_room_id:0,
            last_message_id:null,
            last_activity_timestamp:0,
            onlineStatus(){
                let is_online = Date.now() - 3000*40 > Alpine.store('current_chat').last_activity_timestamp;
                return is_online? "offline" : "online";
            },
            message:"",
            is_disabled:false,
            remaining_chars:500,
            setCurrentCustomerId(customer_id){
                if(this.current_customer.id != null){
                    Echo.leaveChannel('chat_'+this.chat_room_id);
                }

                this.last_message_id=null;
                this.current_customer.id = customer_id;
                let current_customer_chat =
                    Alpine.store('all_chats').items.filter(item=>{
                        return item.other_customer.id == customer_id;
                    });

                // let last_message_id =  null;
                if(current_customer_chat.length){
                    current_customer_chat[0].unread_count = 0;
                    // last_message_id = current_customer_chat[0].last_message.id;
                }

                this.messages = [];
                window.current_customer_id = this.current_customer.id;
                this.loadMessages();


                // this.connectToChatChannel();
                // this.connectToStatusChannel();

                // make all read
                if(this.messages[0] &&this.messages[0].read_at == null){
                    Alpine.store('all_chats').makeAllChatMessagesRead(chat_room_id);
                }

            },
            messages:[],

            // user is now opening a chat window with another
            // He is listening to new events, and new messages are pushed
            // into this chat window
            async loadMessages(){
                await fetch("{{route('customer.get_customer_chats')}}/"+this.current_customer.id+( this.last_message_id? '?last_message_id='+this.last_message_id : ''))
                .then(res => res.json())
                    .then(data => {
                        if(data.messages.length==0){
                            this.show_load_more = false;
                        }else{
                            this.show_load_more = true;
                        }
                        this.messages.unshift(... data.messages.reverse());
                        this.last_message_id = data.messages[0]? data.messages[0].id : null;
                        this.current_customer = data.customer;

                        let chat_room_id = this.chat_room_id;
                        if(this.messages.length){
                            chat_room_id = this.messages[0].chat_id;
                        }
                        this.connectToChatChannel(chat_room_id);
                        this.connectToStatusChannel();
                    });
            },

            connectToChatChannel(chat_room_id){
                if(chat_room_id == this.chat_room_id){
                    return ;
                }

                console.log('connecting to: chat_'+chat_room_id);
                // Connect to this customer's chat channel.
                Echo.private('chat_'+chat_room_id)
                    .listen('NewChatMessage',(message)=>{
                        console.log('NewChatMessage',message);
                        Alpine.store('current_chat').messages.push(message.message);
                        Alpine.store('all_chats').makeAllChatMessagesRead(message.message.chat_id);
                    }).listen('ChatMessageMarkedReadEvent',(message)=>{

                    });
            },

            connectToStatusChannel(){
                // connect to this customer's status channel
                other_customer_channel = Echo.private('customer_'+window.current_customer_id);
                setTimeout(function(){
                    other_customer_channel.listenForWhisper('OtherCustomerStatusChanged', message => {
                        Alpine.store('current_chat').last_activity_timestamp = message.last_active;
                    });
                },1000);
            },

            sendMessage(){
                axios.post('{{route('customer.send_chat')}}',{
                        content:this.message,
                        customer2_id:this.current_customer.id
                }).then(function (response) {
                    Alpine.store('all_chats').items.filter(item=>item.id!=response.data.id).push(response.data);
                    Alpine.store('current_chat').messages.push(response.data.last_message);
                    Alpine.store('current_chat').message='';

                }).catch(function (error) {
                    console.log(error);
                });
            },
            messageCheck(){
                this.remaining_chars = 500 - this.message.length;

                if(this.remaining_chars<=0){
                    this.is_disabled=true;
                }
            },
            getMoreMessages(){
                this.loadMessages();
            }

        });

        setInterval(function(){
            Alpine.store('current_chat').onlineStatus = function(){
                let is_online = Date.now() - 3000*40 > Alpine.store('current_chat').last_activity_timestamp;
                return is_online? "offline" : "online";
            }
        },5000);

        window.Alpine.store('all_chats', {
            unread_count:0,
            items:[],
            get itemsSorted(){
                return this.items.sort((a,b)=>{
                    return b.updated_at_timestamp - a.updated_at_timestamp;
                });
            },
            makeAllChatMessagesRead(chat_id){
                axios.post('{{route('customer.read_all_chat_message')}}/'+chat_id).catch(error=>console.log(error));
            },
            async loadItems(){
                fetch('{{route('customer.get_conversations')}}')
                .then(res => res.json())
                    .then(data => {
                        this.items = data;
                        for(let i=0;i<data.length;i++){
                            this.unread_count += data[i].unread_count;
                        }
                    });
            }
        });


            window.Echo.private('user_chats_{{auth('customer')->id()}}')
            //Other user has read your message
            .listen('MessageWasRead',(message)=>{
            }).listen('NewChat',message=>{
                let all_chats = Alpine.store('all_chats');
                all_chats.items.push(message.chat);

            }).listen('NewChatMessage',message=>{
                console.log(message);
                let all_chats = Alpine.store('all_chats').items;
                let the_chat = all_chats.findIndex(item=>item.id==message.message.chat_id);

                all_chats[the_chat].last_message = message.message;
                setTimeout(function(){
                    all_chats[the_chat].updated_at_timestamp = Date.now();
                    all_chats[the_chat].unread_count ++;
                    Alpine.store('all_chats').unread_count++;
                },100);


            });


        @if(request('customer_id'))
            Alpine.store('current_chat').setCurrentCustomerId({{request('customer_id')}});
        @endif
    });

</script>
@endpush
