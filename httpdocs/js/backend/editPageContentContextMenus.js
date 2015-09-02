function initBindings() {
	$('div.free').contextMenu('freeBlock', {
		bindings: {
			'insertBlock': function(t) {
				insertBlock(t.id);
			},
			'deleteBlock': function(t) {
				deleteBlock(t.id);
			}
		}
	});
	$('div.richtext').contextMenu('freeBlock', {
		bindings: {
			'insertBlock': function(t) {
				insertBlock(t.id);
			},
			'deleteBlock': function(t) {
				deleteBlock(t.id);
			}
		}
	});
}