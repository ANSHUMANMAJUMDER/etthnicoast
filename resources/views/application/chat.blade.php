@extends('layouts.master')
@section('content')
    <!-- Page-content -->
    <div class="page-wrapper">
        <div class="content">
            <div class="col-lg-12">
                <div class="row chat-window">
                
                    <div class="col-lg-7 col-xl-8 chat-cont-right">
                        <div class="card mb-0">
                            <div class="card-header msg_head">
                                <div class="d-flex bd-highlight">
                                    <a id="back_user_list" href="javascript:void(0)" class="back-user-list">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                    <div class="img_cont">
                                        <img class="rounded-circle user_img" src="{{ asset('assets/img/customer/profile2.jpg') }}" alt="">
                                    </div>
                                    <div class="user_info">
                                        <span><strong id="receiver_name">ADMIN</strong></span>
                                        <p class="mb-0">Messages</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body msg_card_body chat-scroll">
                                <ul class="list-unstyled">
                                    <li class="media sent d-flex">
                                        <div class="avatar flex-shrink-0">
                                            <img src="{{ asset('assets/img/customer/customer5.jpg') }}" alt="User Image" class="avatar-img rounded-circle">
                                        </div>
                                        <div class="media-body flex-grow-1">
                                            <div class="msg-box">
                                                <div>
                                                    <p>Hello. What can I do for you?</p>
                                                    <ul class="chat-msg-info">
                                                        <li>
                                                            <div class="chat-time">
                                                                <span>8:30 AM</span>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="media received d-flex">
                                        <div class="avatar flex-shrink-0">
                                            <img src="{{ asset('assets/img/customer/profile2.jpg') }}" alt="User Image" class="avatar-img rounded-circle">
                                        </div>
                                        <div class="media-body flex-grow-1">
                                            <div class="msg-box">
                                                <div>
                                                    <p>I'm just looking around.</p>
                                                    <p>Will you tell me something about yourself?</p>
                                                    <ul class="chat-msg-info">
                                                        <li>
                                                            <div class="chat-time">
                                                                <span>8:35 AM</span>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="msg-box">
                                                <div>
                                                    <p>Are you there? That time!</p>
                                                    <ul class="chat-msg-info">
                                                        <li>
                                                            <div class="chat-time">
                                                                <span>8:40 AM</span>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="msg-box">
                                                <div>
                                                    <div class="chat-msg-attachments">
                                                        <div class="chat-attachment">
                                                            <img src="{{ asset('assets/img/product/product12.jpg') }}" alt="Attachment">
                                                            <a href="" class="chat-attach-download">
                                                                <i class="fas fa-download"></i>
                                                            </a>
                                                        </div>
                                                        <div class="chat-attachment">
                                                            <img src="{{ asset('assets/img/product/product13.jpg') }}" alt="Attachment">
                                                            <a href="" class="chat-attach-download">
                                                                <i class="fas fa-download"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <ul class="chat-msg-info">
                                                        <li>
                                                            <div class="chat-time">
                                                                <span>8:41 AM</span>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="media sent d-flex">
                                        <div class="avatar flex-shrink-0">
                                            <img src="{{ asset('assets/img/customer/customer5.jpg') }}" alt="User Image" class="avatar-img rounded-circle">
                                        </div>
                                        <div class="media-body flex-grow-1">
                                            <div class="msg-box">
                                                <div>
                                                    <p>Where?</p>
                                                    <ul class="chat-msg-info">
                                                        <li>
                                                            <div class="chat-time">
                                                                <span>8:42 AM</span>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="msg-box">
                                                <div>
                                                    <p>OK, my name is Limingqiang. I like singing, playing
                                                        basketballand so on.</p>
                                                    <ul class="chat-msg-info">
                                                        <li>
                                                            <div class="chat-time">
                                                                <span>8:42 AM</span>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="msg-box">
                                                <div>
                                                    <div class="chat-msg-attachments">
                                                        <div class="chat-attachment">
                                                            <img src="{{ asset('assets/img/product/product15.jpg') }}" alt="Attachment">
                                                            <a href="" class="chat-attach-download">
                                                                <i class="fas fa-download"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <ul class="chat-msg-info">
                                                        <li>
                                                            <div class="chat-time">
                                                                <span>8:50 AM</span>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="media received d-flex">
                                        <div class="avatar flex-shrink-0">
                                            <img src="{{ asset('assets/img/customer/profile2.jpg') }}" alt="User Image" class="avatar-img rounded-circle">
                                        </div>
                                        <div class="media-body flex-grow-1">
                                            <div class="msg-box">
                                                <div>
                                                    <p>You wait for notice.</p>
                                                    <p>Consectetuorem ipsum dolor sit?</p>
                                                    <p>Ok?</p>
                                                    <ul class="chat-msg-info">
                                                        <li>
                                                            <div class="chat-time">
                                                                <span>8:55 PM</span>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="chat-date">Today</li>
                                    <li class="media received d-flex">
                                        <div class="avatar flex-shrink-0">
                                            <img src="{{ asset('assets/img/customer/profile2.jpg') }}" alt="User Image" class="avatar-img rounded-circle">
                                        </div>
                                        <div class="media-body flex-grow-1">
                                            <div class="msg-box">
                                                <div>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,</p>
                                                    <ul class="chat-msg-info">
                                                        <li>
                                                            <div class="chat-time">
                                                                <span>10:17 AM</span>
                                                            </div>
                                                        </li>
                                                        <li><a href="javascript:void(0);">Edit</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="media sent d-flex">
                                        <div class="avatar flex-shrink-0">
                                            <img src="{{ asset('assets/img/customer/profile2.jpg') }}" alt="User Image" class="avatar-img rounded-circle">
                                        </div>
                                        <div class="media-body flex-grow-1">
                                            <div class="msg-box">
                                                <div>
                                                    <p>Lorem ipsum dollar sit</p>
                                                    <div class="chat-msg-actions dropdown">
                                                        <a href="javascript:void(0);" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            <i class="fe fe-elipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                                        </div>
                                                    </div>
                                                    <ul class="chat-msg-info">
                                                        <li>
                                                            <div class="chat-time">
                                                                <span>10:19 AM</span>
                                                            </div>
                                                        </li>
                                                        <li><a href="javascript:void(0);">Edit</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="media received d-flex">
                                        <div class="avatar flex-shrink-0">
                                            <img src="{{ asset('assets/img/customer/profile2.jpg') }}" alt="User Image" class="avatar-img rounded-circle">
                                        </div>
                                        <div class="media-body flex-grow-1">
                                            <div class="msg-box">
                                                <div>
                                                    <div class="msg-typing">
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-footer">
                                <div class="input-group">
                                    <input class="form-control type_msg mh-auto empty_check" placeholder="Type your message...">
                                    <button class="btn btn-primary btn_send">
                                        <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page-content -->
@section('script')
@endsection
@endsection