<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ddeboer\Imap\Server;
use Ddeboer\Imap\SearchExpression;
use Ddeboer\Imap\Search\Email\To;
use Ddeboer\Imap\Search\Text\Body;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $server = new Server('imap.gmail.com');

        // $connection is instance of \Ddeboer\Imap\Connection
        $connection = $server->authenticate('musab@qiam.com.sa', 'musab.bebo');
        $mailboxes = $connection->getMailboxes('INBOX');
        
        foreach ($mailboxes as $mailbox) {
            // Skip container-only mailboxes
            // @see https://secure.php.net/manual/en/function.imap-getmailboxes.php
            if ($mailbox->getAttributes() & \LATT_NOSELECT) {
                continue;
            }

            // $mailbox is instance of \Ddeboer\Imap\Mailbox
            //printf('Mailbox "%s" has %s messages', $mailbox->getName(), $mailbox->count());
        }
        $mailbox = $connection->getMailbox('INBOX');
        $messages = $mailbox->getMessages();
        echo "Retrieving " . sizeof($messages) . " emails:\n";
        foreach ($messages as $message) {
            echo "Subject: " . $message->getSubject() . "\n";
            echo "Message: " . $message->getBodyHTML() . "\n";
            if($message->hasAttachments()){
                $attachs = $message->getAttachments();
                foreach($attachs as $attach){
                    $attach->isEmbeddedMessage();
                    $attach->getFileName();
                    $attach->getSize();
                    file_put_contents(
                        public_path().'/Upload/attachments/' . $attach->getFilename(),
                        $attach->getDecodedContent()
                    );
               }
               
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
