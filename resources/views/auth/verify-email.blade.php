<x-auth>
    
    <div class="card">
        <div class="card-header">{{ __('Verify Your Email Address') }}</div>

        <div class="card-body">
            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-success">
                    A new email verification link has been emailed to you!
                </div>
            @endif

            {{ __('Before proceeding, please check your email for a verification link.') }}
            {{ __('If you did not receive the email') }},
            <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-primary rounded f-14 p-2 mt-3 align-baseline">{{ __('click here to request another') }}</button>
            </form>
        </div>
    </div>
    
    <x-slot name="scripts"></x-slot>

</x-auth>
