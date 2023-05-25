@extends('layout.console')

@section('content')
<h1 class="text-3xl">New Script</h1>
<form>
    <div id="prompt">
        <h2 class="text-2xl my-4">Repoter Details</h2>

        <div class="grid gap-6 mb-6 md:grid-cols-2">
            @foreach($segmentFields as $field)
                @switch($field->field_data_type)
                    @case("text")
                        <div>
                            <label for="{{$field->field_name}}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $field->field_name }}</label>
                            <input type="text" id="{{$field->field_name}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{$field->field_name}}" required>
                        </div>
                        @break

                @endswitch
            @endforeach
        </div>
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div class="col-span-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">AI Prompt</label>
                <textarea class="resize-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="prompt"></textarea>
            </div>
        </div>
    </div>
    <h2 class="text-2xl my-4">AI Script</h2>
    <div id="script">
        <pre class="whitespace-pre-wrap break-words resize-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
Emmet: Good morning, folks! You're tuned in to WACKY Radio, where we bring you the news with a twist. I'm Emmet, and joining me as always is the one and only Brick. How's it going, Brick?

Brick: Hey there, Emmet! I'm feeling wackier than a pogo stick on a trampoline. Ready to dive into some news and make it even more offbeat?

Emmet: Absolutely, Brick! So, let's get started. Our top story today is about a rare phenomenon that has left residents scratching their heads. It seems that overnight, the town's beloved statue of the local mayor mysteriously disappeared from the town square.

Brick: Ah, the vanishing mayor! Reminds me of that one time I misplaced my car keys. I searched high and low until I found them in the freezer next to the ice cream. Maybe the mayor decided he needed some chilling out time too?

Emmet: (chuckles) Well, Brick, I don't think the mayor took a vacation in the freezer, but the authorities are baffled by the disappearance. Witnesses claim to have seen a group of squirrels wearing miniature hard hats near the statue just before it vanished.

Brick: Squirrels with hard hats? Now that's nutty! Maybe they're on a secret mission to build an acorn fort, and the mayor's statue was blocking their construction site. Talk about dedication to their architectural pursuits!

Emmet: (laughs) It's an interesting theory, Brick, but the police are currently investigating the matter. In other news, a local bakery has broken the world record for baking the largest cupcake. The giant treat weighs a whopping 2,000 pounds and is decorated with enough frosting to keep a small army in a sugar coma for weeks.

Brick: Emmet, I'm having visions of a frosting tsunami sweeping through the town, with residents running around trying to catch a sweet wave. Who needs surfboards when you have massive cupcakes, right?

Emmet: (chuckles) That would certainly be a sight to see, Brick. But don't worry, the giant cupcake is safely on display at the bakery. Visitors can take pictures with it, but be careful not to get a sugar rush just by looking at it.

Brick: Ah, the perils of indulging in a cupcake photo session. I once had a friend who got a sugar rush just from looking at a picture of a doughnut. You can imagine the chaos when he finally ate one!

Emmet: (laughs) Oh, Brick, you always have the most amusing stories. Moving on, it seems that a local farmer has discovered a patch of rainbow-colored carrots in his garden. These vibrant veggies are causing quite a stir in the community, with people lining up to get a taste of the multicolored crunch.

Brick: Rainbow carrots? Now, that's a feast for the eyes! I bet Bugs Bunny is green with envy. Who needs a pot of gold at the end of a rainbow when you can have a garden of carrots that are pure gold?

Emmet: (laughs) You've got a point there, Brick. The farmer is considering starting a carrot circus, complete with acrobatic acts and carrot juggling. Who knows, maybe we'll witness the world's first vegetable Cirque du Soleil!

Brick: That would be one show I wouldn't want to miss, Emmet. Carrots flying through the air, performing death-defying stunts... the vegetable world truly knows no bounds!

Emmet: That's right, Brick. And that wraps up today's news, folks.
        </pre>
    </div>
    <div id="recording">

    </div>
    <input type="submit" value="Approve">
</form>

@endsection