<div class="sidebar__nav border-top border-left  ">
    <span class="bars d-none padding-0-18"></span>
    <a class="header__logo  d-none" href=""></a>
    <div class="profile__info border cursor-pointer text-center">
        <div class="avatar__img"><img src="/panel/img/pro.jpg" class="avatar___img">
            <input type="file" accept="image/*" class="hidden avatar-img__input">
            <div class="v-dialog__container" style="display: block;"></div>
            <div class="box__camera default__avatar"></div>
        </div>
        <span class="profile__name">کاربر : محمد نیکو</span></div>

    <ul>
        <!--        <li class="item-li i-Dashboard is-active"><a href="index.html">پیشخوان</a></li>
                <li class="item-li i-courses "><a href="courses.html">دوره ها</a></li>
                <li class="item-li i-users"><a href="users.html"> کاربران</a></li>-->


        @foreach(config('sidebar.items') as $item)

            <li class="item-li {{$item['icon']}} @if(str_starts_with(request()->url(),$item["url"])) is-active @endif" >

                <a href="{{$item["url"]}}">{{$item['title']}}</a>

            </li>


    @endforeach
    <!--    <li class="item-li i-slideshow"><a href="slideshow.html">اسلایدشو</a></li>
        <li class="item-li i-banners"><a href="banners.html">بنر ها</a></li>
        <li class="item-li i-articles"><a href="articles.html">مقالات</a></li>
        <li class="item-li i-ads"><a href="ads.html">تبلیغات</a></li>
        <li class="item-li i-comments"><a href="comments.html"> نظرات</a></li>
        <li class="item-li i-tickets"><a href="tickets.html"> تیکت ها</a></li>
        <li class="item-li i-discounts"><a href="discounts.html">تخفیف ها</a></li>
        <li class="item-li i-transactions"><a href="transactions.html">تراکنش ها</a></li>
        <li class="item-li i-checkouts"><a href="checkouts.html">تسویه حساب ها</a></li>
        <li class="item-li i-checkout__request "><a href="checkout-request.html">درخواست تسویه </a></li>
        <li class="item-li i-my__purchases"><a href="mypurchases.html">خرید های من</a></li>
        <li class="item-li i-notification__management"><a href="notification-management.html">مدیریت اطلاع رسانی</a>
        </li>
        <li class="item-li i-user__inforamtion"><a href="User-information.html">اطلاعات کاربری</a></li>
        <li class="item-li i-user__settings"><a href="settings.html">تنظیمات</a></li>-->
    </ul>

</div>
