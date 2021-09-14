<?php

use Illuminate\Database\Seeder;

class SocialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $s = new \App\Social;
        $s->social_type = 'facebook';
        $s->social_key = 'EAAcdQzVsm08BAIVbt9GMqHRGQwH4nOCqWuMOFMHEXzWBBZCeMR9XuJTyhHHTqPvZCg31lZBw67oIdpTxqSIqYjaUPIUs7SYE5YJNPWliAO02xin6wLmWy5ZAszkqbt8wYR1JtIoPvVFpFODDjkZBtR60Oe7UfSspZBhSJpSQy6cJKwPZCBfHWFJ4IDAaRZBIn99cSB3b1q3w8AM32ulNZA9ZBCrqXFwmjqR8EZD';
        $s->social_id = '10212686290566637';
        $s->full_name = 'Dimitrije Mita Dimitrijević';
        $s->email = 'mita@gmail.com';
        $s->save();
        $s->profile_picture = 'https://graph.facebook.com/v2.10/10212686290566637/picture?type=normal';

        // $s = new \App\Social;
        // $s->social_type = 'facebook';
        // $s->social_key = 'EAAcdQzVsm08BAIVbt9GMqHRGQwH4nOCqWuMOFMHEXzWBBZCeMR9XuJTyhHHTqPvZCg31lZBw67oIdpTxqSIqYjaUPIUs7SYE5YJNPWliAO02xin6wLmWy5ZAszkqbt8wYR1JtIoPvVFpFODDjkZBtR60Oe7UfSspZBhSJpSQy6cJKwPZCBfHWFJ4IDAaRZBIn99cSB3b1q3w8AM32ulNZA9ZBCrqXFwmjqR8EZD';
        // $s->social_id = '10212686290566637';
        // $s->full_name = 'Dimitrije Mita Dimitrijević';
        // $s->save();
        // $s->profile_picture = 'https://graph.facebook.com/v2.10/10212686290566637/picture?type=normal';

    }
}
