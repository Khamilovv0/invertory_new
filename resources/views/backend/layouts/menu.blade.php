<style>
    li{
        font-size: 14px !important;
    }
    i{
        margin-right: 5px;
    }
</style>

<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->
    <li class="nav-item">
        <a href="/" class="nav-link">
            <i class="bi bi-house-fill"></i>
            <p>
                {{ __('Главная страница') }}
            </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="bi bi-file-spreadsheet-fill"></i>
            <p>
                Добавление  инвентаря
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{route('createDit')}}" class="nav-link">
                    <i class="bi bi-pc-display"></i>
                    <p>ДИТ</p>
                </a>
            </li>
            {{--<li class="nav-item">
                <a href="{{route('importExcel')}}" class="nav-link">
                    <i class="fa fa-file-excel nav-icon"></i>
                    <p>Импорт через Excel</p>
                </a>
            </li>--}}
            {{--<li class="nav-item">
                <a href="{{route('createDahr')}}" class="nav-link">
                    <i class="far fa-building nav-icon"></i>
                    <p>ДАХР</p>
                </a>
            </li>--}}
        </ul>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="bi bi-database-fill"></i>
            <p>
                Просмотр базы
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{route('all')}}" class="nav-link">
                    <i class="bi bi-globe"></i>
                    <p>Общая база</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('filter')}}" class="nav-link">
                    <i class="bi bi-funnel-fill"></i>
                    <p>Распределенные</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('noSorted')}}" class="nav-link">
                    <i class="bi bi-x-circle"></i>
                    <p>Не распределенные</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('noNumber')}}" class="nav-link">
                    <i class="bi bi-database-fill-dash"></i>
                    <p>Без инвентарного номера</p>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a href="{{route('change_tutor')}}" class="nav-link">
            <i class="bi bi-arrows-fullscreen"></i>
            <p>Перемещение</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{route('open_pdf')}}" class="nav-link">
            <i class="bi bi-pencil-square"></i>
            <p>Формирование описи</p>
        </a>
    </li>

    @php

        $adminTutorID = [646, 359];

    @endphp
    @if (in_array(Auth::user()->TutorID, $adminTutorID))

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-folder-minus"></i>
                <p>
                    Списание
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('write_off')}}" class="nav-link">
                        <i class="bi bi-x-octagon-fill"></i>
                        <p>Списание инвентаря</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('write_off_list')}}" class="nav-link">
                        <i class="bi bi-database-fill-x"></i>
                        <p>База списанного инвентаря</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-gear-fill"></i>
                <p>
                    Настройки
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('synchronize')}}" class="nav-link">
                        <i class="bi bi-arrow-repeat"></i>
                        <p>Синхронизация</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('properties') }}" class="nav-link">
                        <i class="bi bi-list-task"></i>
                        <p>
                            Список свойств
                            <!-- <span class="right badge badge-danger">New</span> -->
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('propertiesadd') }}" class="nav-link">
                        <i class="bi bi-download"></i>
                        <p>
                            Добавить свойства
                            <!-- <span class="right badge badge-danger">New</span> -->
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('category') }}" class="nav-link">
                        <i class="bi bi-card-list"></i>
                        <p>
                            Список наименований
                            <!-- <span class="right badge badge-danger">New</span> -->
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('categoryadd') }}" class="nav-link">
                        <i class="bi bi-plus-circle"></i>
                        <p>
                            Добавить наименования
                            <!-- <span class="right badge badge-danger">New</span> -->
                        </p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="https://ais.kazetu.kz" class="nav-link">
                <i class="bi bi-box-arrow-left"></i>
                <p>
                    Вернуться в АИС
                    <!-- <span class="right badge badge-danger">New</span> -->
                </p>
            </a>
        </li>

    @endif
</ul>
