<h1><?=$title?></h1>

<?php if(!empty($users)) : ?>

    <table class='user-table responsive-table'>
        <thead>
        <tr>
            <th>Acronym</th>
            <th>Email</th>
            <th>Name</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($users as $user) : ?>

            <?php $properties = $user->getProperties(); ?>
            <tr>
                <?php $url = $this->url->create('users/profile/' . $properties['acronym']) ?>
                <td><a href="<?=$url?>"><?=$properties['acronym']?></a></td>
                <td><?=$properties['email']?></td>
                <td><?=$properties['name']?></td>
            </tr>

        <?php endforeach; ?>

    </tbody>
    </table>

<?php else : ?>

    <p>No users found.</p>

<?php endif; ?>