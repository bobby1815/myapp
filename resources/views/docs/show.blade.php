@extends('layouts.app')

@section('content')

    <div class="container">
        <header class="page-header">
            <h2>Markdown Viewer</h2>
            <hr/>
        </header>

        <div class="row">
            <div class="col-md-3 docs__sidebar">
                <aside>
                    {!! $index !!}
                </aside>
            </div>

            <div class="col-md-9 docs__content">
                <article>
                    {!! $content !!}
                </article>
            </div>
        </div>
    </div>
    @stop