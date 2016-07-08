<?php

namespace Matchappen\Http\Middleware;

use Carbon\Carbon;
use Closure;

/*
 * Parses input data in the request through Carbon datetime and puts a valid datetime string back into the input data.
 * Also combines fields suffixed with _date and _time into the main field if conditions are met.
 *
 * Define fields with : and comma-separated list of fieldnames (dot-notated).
 *
 * Example for route definition:
 * 'middleware' => 'input.parse_datetime:birthday,date.start,date.end'
 *
 * Example for controller:
 * $this->middleware('input.parse_datetime:birthday,date.start,date.end');
 *
 */

class ParseDatetimeInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param string ,... $datetime_field
     * @return mixed
     */
    public function handle($request, Closure $next, $datetime_field)
    {
        $input = $request->input(); // The whole input array is pulled out to access and modify it using dot-notation, then put it back into the request when done
        foreach (array_slice(func_get_args(), 2) as $datetime_field) {
            $date_field = $datetime_field . '_date';
            $time_field = $datetime_field . '_time';
            if (array_has($input, $datetime_field)) {
                // The field is present
                // Try to parse it
                try {
                    $carbon = Carbon::parse(array_get($input, $datetime_field));
                    array_set($input, $datetime_field, $carbon->toDateTimeString());
                } catch (\Exception $e) {
                    // The parse failed
                    // Do nothing to the input
                }
            } elseif (array_has($input, $date_field) and array_has($input, $time_field)) {
                // The field is not present but the date and time fields are
                // Combine the date and time parts into the field
                array_set($input, $datetime_field,
                    array_get($input, $date_field) . ' ' . array_get($input, $time_field));
            }
        }
        $request->replace($input);

        return $next($request);
    }
}
