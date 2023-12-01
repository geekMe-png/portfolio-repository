<x-app-layout>
    <div>
        @if(Route::has('login'))
            @auth
            @else
            <div class="container">
                <p class="text-xl font-normal text-red-600">こちらはお試し用のページとなっております。サイトを利用したい方は右上のメニューから新規会員登録かログインをすることでご利用いただけます。</p>
            </div>
            @endauth
            @endif
        <div class="py-11 mx-11">
            <div class="text-center space-y-5">
                <div class="bg-amber-100 py-3 -mx-11 space-y-2">
                    <p class="text-5xl font-light tracking-wider">残高</p>
                    <p class="text-4xl font-thin">{{ $amount_balance }}円</p>
                </div>
                <div class="flex">
                    <div class="flex-1">
                        <h2 class="text-3xl font-light tracking-wider bg-green-400">収入</h2>
                        <p class="text-3xl mt-3 font-thin">{{ $amount_income }}円</p>
                        <h2 class="text-3xl font-extralight mt-5">収入一覧</h2>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-3xl font-light tracking-wider bg-red-400">支出</h2>
                        <p class="text-3xl mt-3 font-thin">{{ $amount_expenditure }}円</p>
                        <h2 class="text-3xl font-extralight mt-5">支出一覧</h2>
                    </div>
                </div>
                <div class="flex pb-11">
                    <table class="table-fixed flex-1">
                        <thead class="text-2xl">
                            <tr>
                                <th class="font-light">日付</th>
                                <th class="font-light">内容</th>
                                <th class="font-light">金額</th>
                            </tr>
                        </thead>
                        @foreach($posts as $post)
                        @if($post->flow==='income')
                        <tbody>
                            <tr class="space-y-2">
                                <th class="font-light">{{$post->date}}</th>
                                <th class="font-light">{{$post->category->category_name??'--'}}</th>
                                <th class="font-light">{{$post->amount}}円</th>
                            </tr>
                        </tbody>
                        @endif
                        @endforeach
                    </table>
                
                    <table class="table-fixed flex-1">
                        <thead class="text-2xl font-light">
                            <tr>
                                <th class="font-light">日付</th>
                                <th class="font-light">内容</th>
                                <th class="font-light">金額</th>
                            </tr>
                        </thead>
                        @foreach($posts as $post)
                        @if($post->flow==='expenditure')
                        <tbody>
                            <tr>
                                <th class="font-light">{{$post->date}}</th>
                                <th class="font-light">{{$post->category->category_name??'--'}}</th>
                                <th class="font-light">{{$post->amount}}円</th>
                            </tr>
                        </tbody>
                        @endif
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    
        <div class="mx-96 text-center bg-amber-100">
            <form method="POST" action="{{ route('input.store') }}" class="py-3 space-y-3">
                @csrf
                <div class="space-y-2">
                    <p class="text-xl font-normal">収入/支出</p>
                    @if($errors->has('flow')) <div class="text-red-500">{{$errors->first('flow')}}</div> @endif
                    <div class="">
                        <div>
                            <label for="income" class="font-normal">収入</label>
                            <input type="radio" id="income" value="income" name="flow" class="mr-4">
                            <label for="expenditure" class="font-normal">支出</label>
                            <input type="radio" id="expenditure" value="expenditure" name="flow" checked required>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="date" class="text-xl font-normal">日付</label>
                    @if($errors->has('date')) <div class="text-red-500">{{$errors->first('date')}}</div> @endif
                    <div><input type="date" id="date" name="date"></div>
                </div>

                <div id="expenditure_selector" class="space-y-2">
                    <label for="category_id" class="text-xl font-normal">内容</label>
                    @if($errors->has('category')) <div>{{$errors->first('category')}}</div> @endif
                    <div><select name="category_id" id="category_id" class="font-normal"></div>
                    @foreach($details as $detail)
                        <option value="{{$detail->id}}">{{$detail->category_name}}</option>
                    @endforeach
                    </select>
                </div>
        
                <div class="space-y-2">
                    <label for="amount" class="text-xl font-normal">金額</label>
                    @if($errors->has('amount')) <div class="text-red-500">{{$errors->first('amount')}}</div> @endif
                    <p class="font-light"><input type="number" min="1" max="10000000" name="amount" id="amount">円</p>
                </div>

                @if(session('message'))
                <div class="text-green-600 font-bold">
                    {{session('message')}}
                </div>
                @endif
        
                <x-primary-button>
                    <input type="button" name="input" value="追加" class="px-3 my-2">
                </x-primary-button>
            </form>
        </div>
        <div class="bg-yellow-50 py-4"></div>
    </div>
</x-app-layout>