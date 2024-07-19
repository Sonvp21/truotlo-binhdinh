<div>
    <h2 class="text-3xl font-extrabold">THÔNG TIN LIÊN HỆ</h2>
    <div class="mt-4">
{{--        <ul class="space-y-2 rounded border border-sky-500 bg-sky-100 p-4 text-sm">--}}
{{--            <li><b>CHỦ NHIỆM ĐỀ TÀI:</b> ThS. Nguyễn Kim Long</li>--}}
{{--            <li><b>ĐƠN VỊ CHỦ TRÌ:</b> Viện Địa công nghệ và Môi trường</li>--}}
{{--            <li><b>VIỆN TRƯỞNG:</b> Đỗ Đình Toát</li>--}}
{{--            <li><b>ĐỊA CHỈ:</b> SỐ 26, ngõ 82 Trần Cung, Phường Nghĩa Tân, Quận Cầu Giấy, Thành phố Hà Nội</li>--}}
{{--            <li><b>ĐIỆN THOẠI:</b> 0243.8362995</li>--}}
{{--        </ul>--}}
        <div class="mt-6">
            <form
                action=""
                class="space-y-4"
            >
                <h3 class="flex items-center gap-2 font-bold">
                    {{ svg('heroicon-o-user', 'size-4') }}
                    Nhập thông tin liên hệ
                </h3>
                <div class="ml-1.5 space-y-4 border-l-4 border-sky-500 pl-4">
                    <div class="flex flex-col">
                        <label
                            class="text-sm text-slate-700"
                            for="name"
                            >Họ và tên<sup class="text-red-500">*</sup></label
                        >
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="rounded border border-slate-300 px-4 text-sm"
                            required
                        />
                    </div>
                    <div class="flex flex-col">
                        <label
                            class="text-sm text-slate-700"
                            for="email"
                            >Email<sup class="text-red-500">*</sup></label
                        >
                        <input
                            type="text"
                            id="email"
                            name="email"
                            class="rounded border border-slate-300 px-4 text-sm"
                            required
                        />
                    </div>
                    <div class="flex flex-col">
                        <label
                            class="text-sm text-slate-700"
                            for="phone"
                            >Số điện thoại<sup class="text-red-500">*</sup></label
                        >
                        <input
                            placeholder="(+84)"
                            type="text"
                            id="phone"
                            name="phone"
                            class="rounded border border-slate-300 px-4 text-sm"
                            required
                        />
                    </div>
                    <div class="flex flex-col">
                        <label
                            class="text-sm text-slate-700"
                            for="message"
                            >Nội dung liên hệ<sup class="text-red-500">*</sup></label
                        >
                        <textarea
                            type="text"
                            id="message"
                            name="message"
                            rows="6"
                            class="rounded border border-slate-300 px-4 text-sm"
                            required
                        ></textarea>
                    </div>
                    <button class="flex items-center gap-2 rounded bg-slate-200 px-4 py-2 hover:bg-slate-300">
                        {{ svg('heroicon-o-paper-airplane', 'size-4 -rotate-45') }}
                        <span>Submit</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
