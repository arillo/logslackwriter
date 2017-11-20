<?php
if (!Director::isDev()) {
	SS_Log::add_writer(new SS_LogSlackWriter(), SS_Log::WARN, '<=');
}
