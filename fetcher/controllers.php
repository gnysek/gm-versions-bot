<?php

class index
{
	public function GET()
	{
		include('fetcher/design/home.php');
	}
}

class api
{
	public function GET()
	{
		include('fetcher/design/api.php');
	}
}

class version
{
	public function GET($version)
	{
		include('fetcher/design/version.php');
	}
}
