    @extends('principal')
    @section('contenido')
        <template v-if="menu==0">
            <div class="p-5 m-5">
                <h1>Contenido del menu: @{{ menu }}</h1>
            </div>
        </template>
        <template v-if="menu==1">
            <categoria></categoria>
        </template>
        <template v-if="menu==2">
            <articulo></articulo>
        </template>
        <template v-if="menu==3">
            <div class="p-5 m-5">
                <h1>Contenido del menu: @{{ menu }}</h1>
            </div>
        </template>
        <template v-if="menu==4">
            <div class="p-5 m-5">
                <h1>Contenido del menu: @{{ menu }}</h1>
            </div>
        </template>
        <template v-if="menu==5">
            <div class="p-5 m-5">
                <h1>Contenido del menu: @{{ menu }}</h1>
            </div>
        </template>
        <template v-if="menu==6">
            <div class="p-5 m-5">
                <h1>Contenido del menu: @{{ menu }}</h1>
            </div>
        </template>
        <template v-if="menu==7">
            <div class="p-5 m-5">
                <h1>Contenido del menu: @{{ menu }}</h1>
            </div>
        </template>
        <template v-if="menu==8">
            <div class="p-5 m-5">
                <h1>Contenido del menu: @{{ menu }}</h1>
            </div>
        </template>
        <template v-if="menu==9">
            <div class="p-5 m-5">
                <h1>Contenido del menu: @{{ menu }}</h1>
            </div>
        </template>
        <template v-if="menu==10">
            <div class="p-5 m-5">
                <h1>Contenido del menu: @{{ menu }}</h1>
            </div>
        </template>
        <template v-if="menu==11">
            <div class="p-5 m-5">
                <h1>Contenido del menu: @{{ menu }}</h1>
            </div>
        </template>
        <template v-if="menu==12">
            <div class="p-5 m-5">
                <h1>Contenido del menu: @{{ menu }}</h1>
            </div>
        </template>

    @endsection