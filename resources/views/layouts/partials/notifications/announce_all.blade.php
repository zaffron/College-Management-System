<div class="dropdown-divider"></div>
<a class="dropdown-item message-container container" onclick="notificationExpander('{{ $notification->data['user']['name'] }}' ,'{{ $notification->data['announcement']['message']}}');" href="#" data-toggle="modal" data-target="#showMessage" data-id="{{ $notification->id }}">
<span class="text-success">
    <strong>From <i class="fa fa-long-arrow-right fa-fw"></i>{{ $notification->data['user']['name'] }}</strong></span>
    <div class="dropdown-message small">{{ $notification->data['announcement']['message']}}</div>
</a>
<div class="dropdown-divider"></div>
<div class="dropdown-footer container">
	<span class="small float-right text-muted">{{ $notification->data['announcement']['created_at']}}</span>	
</div>
