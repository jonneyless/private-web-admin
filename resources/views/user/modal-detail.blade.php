<style>
    .direct-chat-messages {
        /*min-height: 400px;*/
    }

    .ml5 {
        margin-left: 5px;
    }

    .mr5 {
        margin-right: 5px;
    }

    .direct-chat-text {
        position: relative;
        background: #f1f2f6;
        border: 1px solid #f1f2f6;
        color: #000;
        font-size: 14px;
        max-width: 700px;
        padding: 10px;
    }

    .direct-chat-text-left {
        display: inline-block;
        margin-left: 10px !important;
    }

    .direct-chat-text-right {
        display: inline-block;
        float: right;
        margin-right: 10px !important;
        background: #c1e2b3;
    }

    .file_path {
        height: 100px;
        width: 100px;
        cursor: pointer;
    }

    audio {
        margin: 0.3rem 0;
        border: 6px solid #1f618d;
        border-radius: 36px;
    }

    .file-message {
        max-width: 390px;
        width: fit-content;
        display: flex;
        align-items: center;
        gap: 3px;
        padding: 0.6rem 3rem 0.6rem 0.6rem;
        font-size: 18px;
        border-radius: 9px;
        border: 3px solid #34495e;
        background-color: #fef9e7;
        cursor: pointer;
    }

    .direct-chat-text:after,
    .direct-chat-text:before {
        display: none;
    }

    .direct-chat-timestamp {
        color: #666;
        font-size: 14px;
    }

    .direct-chat-name {
        color: #aa4a24;
        font-weight: bold !important;
        font-size: 14px;
    }

    div.direct-chat-img {
        padding-top: 5px;
    }

    img.direct-chat-img {
        margin-top: 5px;
    }

    .direct-chat-img .fa-telegram {
        font-size: 40px;
        color: #00a7d0;
    }

    .triangle {
        width: 0;
        height: 0;
        border-top: 8px solid transparent;
        border-bottom: 8px solid transparent;
    }

    .direct-chat-text .triangle {
        position: absolute;
        top: 10px;
    }

    .direct-chat-text-left .triangle {
        left: -8px;
        border-right: 8px solid #f1f2f6;
    }

    .direct-chat-text-right .triangle {
        right: -8px;
        border-left: 8px solid #c1e2b3;
    }
</style>
<div class="row" style="text-align: left">
    <h3 class="custom-modal-title" style="display: none">{{ $from['fullname'] }}&nbsp;&nbsp;&nbsp;{{ '@' . $from['username'] }}</h3>
    <div class="direct-chat-messages">
        @foreach ($messages as $message)
            @if ($message['user_id'] == -1)
                <div class="direct-chat-msg">
                    <div class="direct-chat-img"><i class="fa fa-telegram"></i></div>
                    <div class="direct-chat-text direct-chat-text-left">
                        <div class="triangle"></div>
                    @if ($message['type'] == 1)
                            {!! $message['info'] !!}
                    @elseif ($message['type'] == 2)
                        <img src="{{ $message['file_path'] }}" alt="" class="file_path">
                    @elseif ($message['type'] == 4)
                        <audio controls>
                            <source src="{{ $message['file_path'] }}"
                                    type="audio/{{ pathinfo($message['file_path'])['extension'] }}">
                        </audio>
                    @elseif ($message['type'] == 5)
                        <video width="190" controls>
                            <source src="{{ $message['file_path'] }}"
                                    type="video/{{ pathinfo($message['file_path'])['extension'] }}">
                        </video>
                    @elseif ($message['type'] == 6)
                        <div class="file-message">
                            <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                        d="M13 3L13.7071 2.29289C13.5196 2.10536 13.2652 2 13 2V3ZM19 9H20C20 8.73478 19.8946 8.48043 19.7071 8.29289L19 9ZM13.109 8.45399L14 8V8L13.109 8.45399ZM13.546 8.89101L14 8L13.546 8.89101ZM10 13C10 12.4477 9.55228 12 9 12C8.44772 12 8 12.4477 8 13H10ZM8 16C8 16.5523 8.44772 17 9 17C9.55228 17 10 16.5523 10 16H8ZM8.5 9C7.94772 9 7.5 9.44772 7.5 10C7.5 10.5523 7.94772 11 8.5 11V9ZM9.5 11C10.0523 11 10.5 10.5523 10.5 10C10.5 9.44772 10.0523 9 9.5 9V11ZM8.5 6C7.94772 6 7.5 6.44772 7.5 7C7.5 7.55228 7.94772 8 8.5 8V6ZM9.5 8C10.0523 8 10.5 7.55228 10.5 7C10.5 6.44772 10.0523 6 9.5 6V8ZM17.908 20.782L17.454 19.891L17.454 19.891L17.908 20.782ZM18.782 19.908L19.673 20.362L18.782 19.908ZM5.21799 19.908L4.32698 20.362H4.32698L5.21799 19.908ZM6.09202 20.782L6.54601 19.891L6.54601 19.891L6.09202 20.782ZM6.09202 3.21799L5.63803 2.32698L5.63803 2.32698L6.09202 3.21799ZM5.21799 4.09202L4.32698 3.63803L4.32698 3.63803L5.21799 4.09202ZM12 3V7.4H14V3H12ZM14.6 10H19V8H14.6V10ZM12 7.4C12 7.66353 11.9992 7.92131 12.0169 8.13823C12.0356 8.36682 12.0797 8.63656 12.218 8.90798L14 8C14.0293 8.05751 14.0189 8.08028 14.0103 7.97537C14.0008 7.85878 14 7.69653 14 7.4H12ZM14.6 8C14.3035 8 14.1412 7.99922 14.0246 7.9897C13.9197 7.98113 13.9425 7.9707 14 8L13.092 9.78201C13.3634 9.92031 13.6332 9.96438 13.8618 9.98305C14.0787 10.0008 14.3365 10 14.6 10V8ZM12.218 8.90798C12.4097 9.2843 12.7157 9.59027 13.092 9.78201L14 8V8L12.218 8.90798ZM8 13V16H10V13H8ZM8.5 11H9.5V9H8.5V11ZM8.5 8H9.5V6H8.5V8ZM13 2H8.2V4H13V2ZM4 6.2V17.8H6V6.2H4ZM8.2 22H15.8V20H8.2V22ZM20 17.8V9H18V17.8H20ZM19.7071 8.29289L13.7071 2.29289L12.2929 3.70711L18.2929 9.70711L19.7071 8.29289ZM15.8 22C16.3436 22 16.8114 22.0008 17.195 21.9694C17.5904 21.9371 17.9836 21.8658 18.362 21.673L17.454 19.891C17.4045 19.9162 17.3038 19.9539 17.0322 19.9761C16.7488 19.9992 16.3766 20 15.8 20V22ZM18 17.8C18 18.3766 17.9992 18.7488 17.9761 19.0322C17.9539 19.3038 17.9162 19.4045 17.891 19.454L19.673 20.362C19.8658 19.9836 19.9371 19.5904 19.9694 19.195C20.0008 18.8114 20 18.3436 20 17.8H18ZM18.362 21.673C18.9265 21.3854 19.3854 20.9265 19.673 20.362L17.891 19.454C17.7951 19.6422 17.6422 19.7951 17.454 19.891L18.362 21.673ZM4 17.8C4 18.3436 3.99922 18.8114 4.03057 19.195C4.06287 19.5904 4.13419 19.9836 4.32698 20.362L6.10899 19.454C6.0838 19.4045 6.04612 19.3038 6.02393 19.0322C6.00078 18.7488 6 18.3766 6 17.8H4ZM8.2 20C7.62345 20 7.25117 19.9992 6.96784 19.9761C6.69617 19.9539 6.59545 19.9162 6.54601 19.891L5.63803 21.673C6.01641 21.8658 6.40963 21.9371 6.80497 21.9694C7.18864 22.0008 7.65645 22 8.2 22V20ZM4.32698 20.362C4.6146 20.9265 5.07354 21.3854 5.63803 21.673L6.54601 19.891C6.35785 19.7951 6.20487 19.6422 6.10899 19.454L4.32698 20.362ZM8.2 2C7.65645 2 7.18864 1.99922 6.80497 2.03057C6.40963 2.06287 6.01641 2.13419 5.63803 2.32698L6.54601 4.10899C6.59545 4.0838 6.69617 4.04612 6.96784 4.02393C7.25117 4.00078 7.62345 4 8.2 4V2ZM6 6.2C6 5.62345 6.00078 5.25117 6.02393 4.96784C6.04612 4.69617 6.0838 4.59545 6.10899 4.54601L4.32698 3.63803C4.13419 4.01641 4.06287 4.40963 4.03057 4.80497C3.99922 5.18864 4 5.65645 4 6.2H6ZM5.63803 2.32698C5.07354 2.6146 4.6146 3.07354 4.32698 3.63803L6.10899 4.54601C6.20487 4.35785 6.35785 4.20487 6.54601 4.10899L5.63803 2.32698Z"
                                        fill="#6f6f6f"/>
                            </svg>
                            <div style="display: flex-row;">
                                <p style="margin:0; font-weight: bold !important; overflow:hidden;">
                                    {{ $message['file_name'] }}</p>
                                <p style="margin:0; font-weight: bold !important; font-size:12px;color:#6f6f6f;">
                                    {{ pathinfo($message['file_path'])['extension'] }} - 文件</p>
                            </div>
                            <a href="{{ $message['file_path'] }}" hidden>{{ $message['file_path'] }}</a>
                        </div>
                    @endif

                        <div class="direct-chat-info clearfix">
                            <span class="direct-chat-timestamp pull-left">{{ $message['created_at'] }}</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="direct-chat-msg right">
                    <img class="direct-chat-img" src="/img/hwdb.jpg"/>
                    <div class="direct-chat-text direct-chat-text-right">
                        <div class="triangle"></div>
                    @if ($message['type'] == 1)
                            {!! $message['info'] !!}
                    @elseif ($message['type'] == 2)
                            <img src="{{ $message['file_path'] }}" alt="" class="file_path">
                    @elseif ($message['type'] == 4)
                            <audio controls>
                                <source src="{{ $message['file_path'] }}" type="audio/{{ pathinfo($message['file_path'])['extension'] }}">
                            </audio>
                    @elseif ($message['type'] == 5)
                            <video width="190" controls>
                                <source src="{{ $message['file_path'] }}" type="video/{{ pathinfo($message['file_path'])['extension'] }}">
                            </video>
                    @elseif ($message['type'] == 6)
                            <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                        d="M13 3L13.7071 2.29289C13.5196 2.10536 13.2652 2 13 2V3ZM19 9H20C20 8.73478 19.8946 8.48043 19.7071 8.29289L19 9ZM13.109 8.45399L14 8V8L13.109 8.45399ZM13.546 8.89101L14 8L13.546 8.89101ZM10 13C10 12.4477 9.55228 12 9 12C8.44772 12 8 12.4477 8 13H10ZM8 16C8 16.5523 8.44772 17 9 17C9.55228 17 10 16.5523 10 16H8ZM8.5 9C7.94772 9 7.5 9.44772 7.5 10C7.5 10.5523 7.94772 11 8.5 11V9ZM9.5 11C10.0523 11 10.5 10.5523 10.5 10C10.5 9.44772 10.0523 9 9.5 9V11ZM8.5 6C7.94772 6 7.5 6.44772 7.5 7C7.5 7.55228 7.94772 8 8.5 8V6ZM9.5 8C10.0523 8 10.5 7.55228 10.5 7C10.5 6.44772 10.0523 6 9.5 6V8ZM17.908 20.782L17.454 19.891L17.454 19.891L17.908 20.782ZM18.782 19.908L19.673 20.362L18.782 19.908ZM5.21799 19.908L4.32698 20.362H4.32698L5.21799 19.908ZM6.09202 20.782L6.54601 19.891L6.54601 19.891L6.09202 20.782ZM6.09202 3.21799L5.63803 2.32698L5.63803 2.32698L6.09202 3.21799ZM5.21799 4.09202L4.32698 3.63803L4.32698 3.63803L5.21799 4.09202ZM12 3V7.4H14V3H12ZM14.6 10H19V8H14.6V10ZM12 7.4C12 7.66353 11.9992 7.92131 12.0169 8.13823C12.0356 8.36682 12.0797 8.63656 12.218 8.90798L14 8C14.0293 8.05751 14.0189 8.08028 14.0103 7.97537C14.0008 7.85878 14 7.69653 14 7.4H12ZM14.6 8C14.3035 8 14.1412 7.99922 14.0246 7.9897C13.9197 7.98113 13.9425 7.9707 14 8L13.092 9.78201C13.3634 9.92031 13.6332 9.96438 13.8618 9.98305C14.0787 10.0008 14.3365 10 14.6 10V8ZM12.218 8.90798C12.4097 9.2843 12.7157 9.59027 13.092 9.78201L14 8V8L12.218 8.90798ZM8 13V16H10V13H8ZM8.5 11H9.5V9H8.5V11ZM8.5 8H9.5V6H8.5V8ZM13 2H8.2V4H13V2ZM4 6.2V17.8H6V6.2H4ZM8.2 22H15.8V20H8.2V22ZM20 17.8V9H18V17.8H20ZM19.7071 8.29289L13.7071 2.29289L12.2929 3.70711L18.2929 9.70711L19.7071 8.29289ZM15.8 22C16.3436 22 16.8114 22.0008 17.195 21.9694C17.5904 21.9371 17.9836 21.8658 18.362 21.673L17.454 19.891C17.4045 19.9162 17.3038 19.9539 17.0322 19.9761C16.7488 19.9992 16.3766 20 15.8 20V22ZM18 17.8C18 18.3766 17.9992 18.7488 17.9761 19.0322C17.9539 19.3038 17.9162 19.4045 17.891 19.454L19.673 20.362C19.8658 19.9836 19.9371 19.5904 19.9694 19.195C20.0008 18.8114 20 18.3436 20 17.8H18ZM18.362 21.673C18.9265 21.3854 19.3854 20.9265 19.673 20.362L17.891 19.454C17.7951 19.6422 17.6422 19.7951 17.454 19.891L18.362 21.673ZM4 17.8C4 18.3436 3.99922 18.8114 4.03057 19.195C4.06287 19.5904 4.13419 19.9836 4.32698 20.362L6.10899 19.454C6.0838 19.4045 6.04612 19.3038 6.02393 19.0322C6.00078 18.7488 6 18.3766 6 17.8H4ZM8.2 20C7.62345 20 7.25117 19.9992 6.96784 19.9761C6.69617 19.9539 6.59545 19.9162 6.54601 19.891L5.63803 21.673C6.01641 21.8658 6.40963 21.9371 6.80497 21.9694C7.18864 22.0008 7.65645 22 8.2 22V20ZM4.32698 20.362C4.6146 20.9265 5.07354 21.3854 5.63803 21.673L6.54601 19.891C6.35785 19.7951 6.20487 19.6422 6.10899 19.454L4.32698 20.362ZM8.2 2C7.65645 2 7.18864 1.99922 6.80497 2.03057C6.40963 2.06287 6.01641 2.13419 5.63803 2.32698L6.54601 4.10899C6.59545 4.0838 6.69617 4.04612 6.96784 4.02393C7.25117 4.00078 7.62345 4 8.2 4V2ZM6 6.2C6 5.62345 6.00078 5.25117 6.02393 4.96784C6.04612 4.69617 6.0838 4.59545 6.10899 4.54601L4.32698 3.63803C4.13419 4.01641 4.06287 4.40963 4.03057 4.80497C3.99922 5.18864 4 5.65645 4 6.2H6ZM5.63803 2.32698C5.07354 2.6146 4.6146 3.07354 4.32698 3.63803L6.10899 4.54601C6.20487 4.35785 6.35785 4.20487 6.54601 4.10899L5.63803 2.32698Z"
                                        fill="#6f6f6f"/>
                            </svg>
                            <div style="display: flex-row;">
                                <p style="margin:0; font-weight: bold !important; overflow:hidden;">
                                    {{ $message['file_name'] }}</p>
                                <p style="margin:0; font-weight: bold !important; font-size:12px;color:#6f6f6f;">
                                    {{ pathinfo($message['file_path'])['extension'] }} - 文件</p>
                            </div>
                            <a href="{{ $message['file_path'] }}" hidden>{{ $message['file_path'] }}</a>
                    @endif
                        <div class="direct-chat-info clearfix">
                            <span class="direct-chat-timestamp pull-right">{{ $message['created_at'] }}</span>
                        </div>
                        <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name pull-right">{{ $fullname }}</span>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>