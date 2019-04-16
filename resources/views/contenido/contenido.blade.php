    @extends('principal')
    @section('contenido')
        <template v-if="menu==0">
            <example-component></example-component>
        </template>
        <template v-if="menu==1">
            <div class="container">
                <h1>Contenido del menu: @{{ menu }}</h1>
            </div>
        </template>
        <template v-if="menu==2">
            <div class="container">
                <h1>Contenido del menu: @{{ menu }}</h1>
            </div>
        </template>
        <template v-if="menu==3">
            <div class="container">
                <h1>Contenido del menu: @{{ menu }}</h1>
            </div>
        </template>
        <template v-if="menu==4">
            <div class="container">
                <h1>Contenido del menu: @{{ menu }}</h1>
            </div>
        </template>
        <template v-if="menu==5">
            <div class="container">
                <h1>Contenido del menu: @{{ menu }}</h1>
            </div>
        </template>
        <template v-if="menu==6">
            <div class="container">
                <h1>Contenido del menu: @{{ menu }}</h1>
            </div>
        </template>
        <template v-if="menu==7">
            <div class="container">
                <h1>Contenido del menu: @{{ menu }}</h1>
            </div>
        </template>
        <template v-if="menu==8">
            <div class="container">
                <h1>Contenido del menu: @{{ menu }}</h1>
            </div>
        </template>
        <template v-if="menu==9">
            <div class="container">
                <h1>Contenido del menu: @{{ menu }}</h1>
            </div>
        </template>
        <template v-if="menu==10">
            <div class="container">
                <h1>Contenido del menu: @{{ menu }}</h1>
            </div>
        </template>
        <template v-if="menu==11">
            <div class="container">
                <h1>Contenido del menu: @{{ menu }}</h1>
            </div>
        </template>
        <template v-if="menu==12">
            <div class="container">
                <h1>Contenido del menu: @{{ menu }}</h1>
            </div>
        </template>

    @endsection