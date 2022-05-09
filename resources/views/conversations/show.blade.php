@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="container">
            <div class="row">
                @include('conversations.users', ['users' => $users, 'unread' => $unread])
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">{{ $user->name }}</div>
                        <div class="card-body conversations">
                            @if ($messages->hasMorePages())
                                <div class="text-center">
                                    <a href="{{ $messages->nextPageUrl() }}" class="btn btn-light">Voir les
                                        messagesprécédentes</a>
                                </div>
                            @endif
                            @foreach (array_reverse($messages->items()) as $message)
                                <div class="row">
                                    <div class="col-md-5">
                                        <table class="table">
                                        <thead>
                                              Thrust ✈️📨
                                            </thead>
                                            <tbody>
                                              <tr class="table-active">
                                                <td colspan="5" class="table-active ">                                               
                                                    Aucun commentaire
                                                </td>
                                              </tr>
                                              <tr>
                                                <td colspan="5" class="table-active success">TERMINER</td>
                                              </tr>
                                            </tbody>
                                          </table>

                                    </div>
                                    <div class="col-md-10 {{ $message->from->id !== $user->id ? 'offset-md-2 text-right' : '' }} ">
                                        <p>{{ $message->created_at }}</p>
                                        <strong>{{ $message->from->id !== $user->id ? 'Moi' : $message->from->name }}</strong>
                                        <br>
                                        {!! nl2br(e($message->content)) !!}

                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        </div>
                        @if ($messages->hasMorePages())
                            <div class="text-center">
                                <a href="{{ $messages->previousPageUrl() }}" class="btn btn-light">Voir les messages
                                    plus récent</a>
                            </div>
                        @endif
                        <form action="" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group ">
                                <textarea name="content" placeholder="Ecrivez votre message"
                                    class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}"></textarea>
                                @if ($errors->has('content'))
                                    <div class="invalid-feedback ">{{ implode(',', $errors->get('content')) }}</div>
                                @endif
                            </div>

                            <button class="btn btn-primary" type="submit">Envoyer ✈️</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
