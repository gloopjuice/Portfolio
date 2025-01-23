<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Stack;
use App\Models\Project;
use App\Models\Music_project;
class ApiController extends Controller
{
    public function createStack(Request $request)
    {
        $request->validate([
            'stackname' => 'required|string|max:255',
            'stackdescription' => 'required|string',
            'stackpicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $picturePath = null;
        if ($request->hasFile('stackpicture')) {
            $picturePath = $request->file('stackpicture')->store('stackpictures', 'public');
        }

        $stack = Stack::create([
            'stackname' => $request->stackname,
            'stackdescription' => $request->stackdescription,
            'stackpicture' => $picturePath,
        ]);

        return response()->json(['message' => 'Stack created successfully', 'stack' => $stack], 201);
    }

    public function deleteStack($id)
    {
        $stack = Stack::find($id);
        if (!$stack) {
            return response()->json(['message' => 'Stack not found'], 404);
        }
        if ($stack->stackpicture) {
            \Storage::disk('public')->delete($stack->stackpicture);
        }
        $stack->delete();

        return response()->json(['message' => 'Stack deleted successfully'], 200);
    }

    public function getStacks()
    {
        $stacks = Stack::all();
        return response()->json($stacks, 200);
    }

    public function editStack(Request $request, $id)
    {
        $stack = Stack::find($id);
        if (!$stack) {
            return response()->json(['message' => 'Stack not found'], 404);
        }

        $request->validate([
            'stackname' => 'nullable|string|max:255',
            'stackdescription' => 'nullable|string',
            'stackpicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('stackpicture')) {
            if ($stack->stackpicture) {
                \Storage::disk('public')->delete($stack->stackpicture);
            }
            $stack->stackpicture = $request->file('stackpicture')->store('stackpictures', 'public');
        }

        $stack->update($request->only(['stackname', 'stackdescription']));

        return response()->json(['message' => 'Stack updated successfully', 'stack' => $stack], 200);
    }

    public function createProject(Request $request)
    {
        $request->validate([
            'projectname' => 'required|string|max:255',
            'projectdescription' => 'required|string',
            'projectpicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $picturePath = null;
        if ($request->hasFile('projectpicture')) {
            $picturePath = $request->file('projectpicture')->store('projectpictures', 'public');
        }

        $project = Project::create([
            'projectname' => $request->projectname,
            'projectdescription' => $request->projectdescription,
            'projectpicture' => $picturePath,
        ]);

        return response()->json(['message' => 'Project created successfully', 'project' => $project], 201);
    }

    public function deleteProject($id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }
        if ($project->projectpicture) {
            \Storage::disk('public')->delete($project->projectpicture);
        }
        $project->delete();

        return response()->json(['message' => 'Project deleted successfully'], 200);
    }

    public function getProjects()
    {
        $projects = Project::all();
        return response()->json($projects, 200);
    }

    public function editProject(Request $request, $id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $request->validate([
            'projectname' => 'nullable|string|max:255',
            'projectdescription' => 'nullable|string',
            'projectpicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('projectpicture')) {
            if ($project->projectpicture) {
                \Storage::disk('public')->delete($project->projectpicture);
            }
            $project->projectpicture = $request->file('projectpicture')->store('projectpictures', 'public');
        }

        $project->update($request->only(['projectname', 'projectdescription']));

        return response()->json(['message' => 'Project updated successfully', 'project' => $project], 200);
    }

    public function createMusicProject(Request $request)
    {
        $request->validate([
            'musicprojectname' => 'required|string|max:255',
            'musicprojectdescription' => 'required|string',
            'musicprojectpicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $picturePath = null;
        if ($request->hasFile('musicprojectpicture')) {
            $picturePath = $request->file('musicprojectpicture')->store('musicprojectpictures', 'public');
        }

        $musicProject = Music_project::create([
            'musicprojectname' => $request->musicprojectname,
            'musicprojectdescription' => $request->musicprojectdescription,
            'musicprojectpicture' => $picturePath,
        ]);

        return response()->json(['message' => 'Music project created successfully', 'musicProject' => $musicProject], 201);
    }

    public function deleteMusicProject($id)
    {
        $musicProject = Music_project::find($id);
        if (!$musicProject) {
            return response()->json(['message' => 'Music project not found'], 404);
        }
        if ($musicProject->musicprojectpicture) {
            \Storage::disk('public')->delete($musicProject->musicprojectpicture);
        }
        $musicProject->delete();

        return response()->json(['message' => 'Music project deleted successfully'], 200);
    }

    public function getMusicProjects()
    {
        $musicProjects = Music_project::all();
        return response()->json($musicProjects, 200);
    }

    public function editMusicProject(Request $request, $id)
    {
        $musicProject = Music_project::find($id);
        if (!$musicProject) {
            return response()->json(['message' => 'Music project not found'], 404);
        }

        $request->validate([
            'musicprojectname' => 'nullable|string|max:255',
            'musicprojectdescription' => 'nullable|string',
            'musicprojectpicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('musicprojectpicture')) {
            if ($musicProject->musicprojectpicture) {
                \Storage::disk('public')->delete($musicProject->musicprojectpicture);
            }
            $musicProject->musicprojectpicture = $request->file('musicprojectpicture')->store('musicprojectpictures', 'public');
        }

        $musicProject->update($request->only(['musicprojectname', 'musicprojectdescription']));

        return response()->json(['message' => 'Music project updated successfully', 'musicProject' => $musicProject], 200);
    }
}

