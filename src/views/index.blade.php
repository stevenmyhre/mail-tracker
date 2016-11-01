@extends(config('mail-tracker.admin-template.name'))
@section(config('mail-tracker.admin-template.section'))
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1>Mail Tracker</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-center">
                <form action="{{ route('mailTracker_Search') }}" method="post" class="form-inline">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="search">
                            Search
                        </label>
                        <input type="text" name="search" id="search" value="{{ session('mail-tracker-index-search') }}">
                    </div>
                    <button type="submit" class="btn btn-default">
                        Search
                    </button>
                    <div class="btn btn-default">
                        <a href="{{ route('mailTracker_ClearSearch') }}">
                            Clear Search
                        </a>
                    </div>
                </form>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-striped">
                    <tr>
                        <th>Recipient</th>
                        <th>Subject</th>
                        <th>Opens</th>
                        <th>Clicks</th>
                        <th>Send At</th>
                        <th>View Email</th>
                        <th>Clicks</th>
                    </tr>
                @foreach($emails as $email)
                    <tr>
                      <td>{{$email->recipient}}</td>
                      <td>{{$email->subject}}</td>
                      <td>{{$email->opens}}</td>
                      <td>{{$email->clicks}}</td>
                      <td>{{$email->created_at->format(config('mail-tracker.date-format'))}}</td>
                      <td>
                          <a href="{{route('mailTracker_ShowEmail',$email->id)}}" target="_blank">View</a>
                      </td>
                      <td>
                          @if($email->clicks > 0)
                              <a href="{{route('mailTracker_UrlDetail',$email->id)}}">Url Report</a>
                          @else
                              No Clicks
                          @endif
                      </td>
                    </tr>
                @endforeach
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-center">
                {!! $emails->render() !!}
            </div>
        </div>
    </div>
@endsection
