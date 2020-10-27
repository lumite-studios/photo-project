<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $permission)
    {
		$can = false;

		if(auth()->check())
		{
			switch($permission) {
				case 'view':
					if(auth()->user()->canView()) { $can = true; }
					break;
				case 'invite':
					if(auth()->user()->canInvite()) { $can = true; }
					break;
				case 'upload':
					if(auth()->user()->canUpload()) { $can = true; }
					break;
				case 'edit':
					if(auth()->user()->canEdit()) { $can = true; }
					break;
				case 'delete':
					if(auth()->user()->canDelete()) { $can = true; }
					break;
				case 'admin':
					if(auth()->user()->canAdmin()) { $can = true; }
					break;
			}
		}

        return $can ? $next($request) : redirect('dashboard');
    }
}
